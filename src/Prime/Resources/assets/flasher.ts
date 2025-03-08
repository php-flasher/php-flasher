/**
 * @file Flasher Core
 * @description Main orchestration class for the PHPFlasher notification system
 * @author Younes ENNAJI
 */
import type { Asset, Context, Envelope, Options, PluginInterface, Response, Theme } from './types'
import { AbstractPlugin } from './plugin'
import FlasherPlugin from './flasher-plugin'

/**
 * Main Flasher class that manages plugins, themes, and notifications.
 *
 * Flasher is the central orchestration class for PHPFlasher. It handles:
 * 1. Plugin registration and management
 * 2. Theme registration and resolution
 * 3. Asset loading (JS and CSS)
 * 4. Routing notifications to the appropriate plugin
 * 5. Response processing and normalization
 *
 * This class follows the façade pattern, providing a simple interface to the
 * underlying plugin ecosystem.
 *
 * @example
 * ```typescript
 * // Create a flasher instance
 * const flasher = new Flasher();
 *
 * // Register a plugin
 * flasher.addPlugin('toastr', new ToastrPlugin());
 *
 * // Show a notification
 * flasher.use('toastr').success('Operation completed successfully');
 *
 * // Process server response
 * flasher.render(response);
 * ```
 */
export default class Flasher extends AbstractPlugin {
    /**
     * Default plugin to use when none is specified.
     * This plugin will be used when displaying notifications without
     * explicitly specifying a plugin.
     *
     * @private
     */
    private defaultPlugin = 'flasher'

    /**
     * Map of registered plugins.
     * Stores plugin instances by name for easy lookup.
     *
     * @private
     */
    private plugins: Map<string, PluginInterface> = new Map<string, PluginInterface>()

    /**
     * Map of registered themes.
     * Stores theme configurations by name.
     *
     * @private
     */
    private themes: Map<string, Theme> = new Map<string, Theme>()

    /**
     * Set of assets that have been loaded.
     * Used to prevent duplicate loading of the same asset.
     *
     * @private
     */
    private loadedAssets: Set<string> = new Set<string>()

    /**
     * Renders notifications from a response.
     *
     * This method processes a server response containing notifications and configuration.
     * It handles asset loading, option application, and notification rendering in a
     * coordinated sequence.
     *
     * @param response - The response containing notifications and configuration
     * @returns A promise that resolves when all operations are complete
     *
     * @example
     * ```typescript
     * // From an AJAX response
     * const response = await fetch('/api/notifications').then(r => r.json());
     * await flasher.render(response);
     *
     * // With a partial response
     * flasher.render({
     *   envelopes: [
     *     { message: 'Hello world', type: 'info', title: 'Greeting', options: {}, metadata: {} }
     *   ]
     * });
     * ```
     */
    public async render(response: Partial<Response>): Promise<void> {
        const resolved = this.resolveResponse(response)

        try {
            // Load required assets
            await this.addAssets([
                {
                    urls: resolved.styles,
                    nonce: resolved.context.csp_style_nonce as string,
                    type: 'style',
                },
                {
                    urls: resolved.scripts,
                    nonce: resolved.context.csp_script_nonce as string,
                    type: 'script',
                },
            ])

            // Apply options and render notifications
            this.renderOptions(resolved.options)
            this.renderEnvelopes(resolved.envelopes)
        } catch (error) {
            console.error('PHPFlasher: Error rendering notifications', error)
        }
    }

    /**
     * Renders multiple notification envelopes.
     *
     * This method groups envelopes by plugin and delegates rendering to each plugin.
     * This ensures that each notification is processed by the appropriate plugin.
     *
     * @param envelopes - Array of notification envelopes to render
     *
     * @example
     * ```typescript
     * flasher.renderEnvelopes([
     *   {
     *     message: 'Operation completed',
     *     type: 'success',
     *     title: 'Success',
     *     options: {},
     *     metadata: { plugin: 'toastr' }
     *   },
     *   {
     *     message: 'An error occurred',
     *     type: 'error',
     *     title: 'Error',
     *     options: {},
     *     metadata: { plugin: 'sweetalert' }
     *   }
     * ]);
     * ```
     */
    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!envelopes?.length) {
            return
        }

        const groupedByPlugin: Record<string, Envelope[]> = {}

        // Group envelopes by plugin for batch processing
        envelopes.forEach((envelope) => {
            const plugin = this.resolvePluginAlias(envelope.metadata.plugin)
            groupedByPlugin[plugin] = groupedByPlugin[plugin] || []
            groupedByPlugin[plugin].push(envelope)
        })

        // Render each group with the appropriate plugin
        Object.entries(groupedByPlugin).forEach(([pluginName, pluginEnvelopes]) => {
            try {
                this.use(pluginName).renderEnvelopes(pluginEnvelopes)
            } catch (error) {
                console.error(`PHPFlasher: Error rendering envelopes for plugin "${pluginName}"`, error)
            }
        })
    }

    /**
     * Applies options to each plugin.
     *
     * This method distributes options to the appropriate plugins based on the keys
     * in the options object. Each plugin receives only its specific options.
     *
     * @param options - Object mapping plugin names to their specific options
     *
     * @example
     * ```typescript
     * flasher.renderOptions({
     *   toastr: { timeOut: 3000, closeButton: true },
     *   sweetalert: { confirmButtonColor: '#3085d6' }
     * });
     * ```
     */
    public renderOptions(options: Options): void {
        if (!options) {
            return
        }

        Object.entries(options).forEach(([plugin, option]) => {
            try {
                // @ts-expect-error - We know this is an Options object
                this.use(plugin).renderOptions(option)
            } catch (error) {
                console.error(`PHPFlasher: Error applying options for plugin "${plugin}"`, error)
            }
        })
    }

    /**
     * Registers a new plugin.
     *
     * Plugins are the notification renderers that actually display notifications.
     * Each plugin typically integrates with a specific notification library like
     * Toastr, SweetAlert, etc.
     *
     * @param name - Unique identifier for the plugin
     * @param plugin - Plugin instance that implements the PluginInterface
     * @throws {Error} If name or plugin is invalid
     *
     * @example
     * ```typescript
     * // Register a custom plugin
     * flasher.addPlugin('myplugin', new MyCustomPlugin());
     *
     * // Use the registered plugin
     * flasher.use('myplugin').info('Hello world');
     * ```
     */
    public addPlugin(name: string, plugin: PluginInterface): void {
        if (!name || !plugin) {
            throw new Error('Both plugin name and instance are required')
        }
        this.plugins.set(name, plugin)
    }

    /**
     * Registers a new theme.
     *
     * Themes define the visual appearance of notifications when using
     * the default FlasherPlugin. They provide HTML templates and CSS styles.
     *
     * @param name - Unique identifier for the theme
     * @param theme - Theme configuration object
     * @throws {Error} If name or theme is invalid
     *
     * @example
     * ```typescript
     * // Register a bootstrap theme
     * flasher.addTheme('bootstrap', {
     *   styles: ['bootstrap.min.css'],
     *   render: (envelope) => `
     *     <div class="alert alert-${envelope.type}">
     *       <h4>${envelope.title}</h4>
     *       <p>${envelope.message}</p>
     *     </div>
     *   `
     * });
     *
     * // Use the theme
     * flasher.use('theme.bootstrap').success('Hello world');
     * ```
     */
    public addTheme(name: string, theme: Theme): void {
        if (!name || !theme) {
            throw new Error('Both theme name and definition are required')
        }
        this.themes.set(name, theme)
    }

    /**
     * Gets a plugin by name.
     *
     * This method resolves plugin aliases and creates theme-based plugins
     * on demand. If a theme-based plugin is requested but doesn't exist yet,
     * it will be created automatically.
     *
     * @param name - Name of the plugin to retrieve
     * @returns The requested plugin instance
     * @throws {Error} If the plugin cannot be resolved
     *
     * @example
     * ```typescript
     * // Get and use a plugin
     * const toastr = flasher.use('toastr');
     * toastr.success('Operation completed');
     *
     * // Use a theme as a plugin (automatically creates a FlasherPlugin)
     * flasher.use('theme.bootstrap').error('Something went wrong');
     * ```
     */
    public use(name: string): PluginInterface {
        const resolvedName = this.resolvePluginAlias(name)
        this.resolvePlugin(resolvedName)

        const plugin = this.plugins.get(resolvedName)
        if (!plugin) {
            throw new Error(`Unable to resolve "${resolvedName}" plugin, did you forget to register it?`)
        }

        return plugin
    }

    /**
     * Alias for use().
     *
     * @param name - Name of the plugin to retrieve
     * @returns The requested plugin instance
     */
    public create(name: string): PluginInterface {
        return this.use(name)
    }

    /**
     * Resolves and normalizes a response object.
     *
     * This method:
     * 1. Fills in default values for missing properties
     * 2. Resolves plugin aliases for envelopes
     * 3. Converts string functions to actual functions
     * 4. Adds theme styles to the response
     *
     * @param response - Partial response object
     * @returns Fully resolved response object
     * @private
     */
    private resolveResponse(response: Partial<Response>): Response {
        const resolved = {
            envelopes: [],
            options: {},
            scripts: [],
            styles: [],
            context: {},
            ...response,
        } as Response

        // Process options
        Object.entries(resolved.options).forEach(([plugin, options]) => {
            resolved.options[plugin] = this.resolveOptions(options)
        })

        // Set default CSP nonces if not provided
        resolved.context.csp_style_nonce = resolved.context.csp_style_nonce || ''
        resolved.context.csp_script_nonce = resolved.context.csp_script_nonce || ''

        // Process envelopes
        resolved.envelopes.forEach((envelope) => {
            envelope.metadata = envelope.metadata || {}
            envelope.metadata.plugin = this.resolvePluginAlias(envelope.metadata.plugin)
            this.addThemeStyles(resolved, envelope.metadata.plugin)
            envelope.options = this.resolveOptions(envelope.options)
            envelope.context = response.context as Context
        })

        return resolved
    }

    /**
     * Resolves string functions to actual function objects.
     *
     * This allows options to include functions serialized as strings,
     * which is useful for passing functions from the server to the client.
     *
     * @param options - Options object that may contain string functions
     * @returns Options object with string functions converted to actual functions
     * @private
     */
    private resolveOptions(options: Options): Options {
        if (!options) {
            return {}
        }

        const resolved = { ...options }

        Object.entries(resolved).forEach(([key, value]) => {
            resolved[key] = this.resolveFunction(value)
        })

        return resolved
    }

    /**
     * Converts a string function representation to an actual function.
     *
     * Supports both traditional and arrow function syntax:
     * - `function(a, b) { return a + b; }`
     * - `(a, b) => a + b`
     * - `a => a * 2`
     *
     * @param func - Value to check and potentially convert
     * @returns Function if conversion was successful, otherwise the original value
     * @private
     */
    private resolveFunction(func: unknown): unknown {
        if (typeof func !== 'string') {
            return func
        }

        const functionRegex = /^function\s*(\w*)\s*\(([^)]*)\)\s*\{([\s\S]*)\}$/
        const arrowFunctionRegex = /^\s*(\(([^)]*)\)|[^=]+)\s*=>\s*([\s\S]+)$/

        const match = func.match(functionRegex) || func.match(arrowFunctionRegex)
        if (!match) {
            return func
        }

        const args = match[2]?.split(',').map((arg) => arg.trim()) ?? []
        let body = match[3].trim()

        // Arrow functions with a single expression can omit the curly braces and the return keyword
        if (!body.startsWith('{')) {
            body = `{ return ${body}; }`
        }

        try {
            // eslint-disable-next-line no-new-func
            return new Function(...args, body)
        } catch (e) {
            console.error('PHPFlasher: Error converting string to function:', e)
            return func
        }
    }

    /**
     * Creates theme-based plugins on demand.
     *
     * This method automatically creates a FlasherPlugin instance for a theme
     * when a theme-based plugin is requested but doesn't exist yet.
     *
     * @param alias - Plugin alias to resolve
     * @private
     */
    private resolvePlugin(alias: string): void {
        const factory = this.plugins.get(alias)
        if (factory || !alias.includes('theme.')) {
            return
        }

        const themeName = alias.replace('theme.', '')
        const theme = this.themes.get(themeName)
        if (!theme) {
            return
        }

        // Create and register a FlasherPlugin for this theme
        this.addPlugin(alias, new FlasherPlugin(theme))
    }

    /**
     * Resolves a plugin name to its actual implementation name.
     *
     * This method handles the default plugin and theme aliases.
     *
     * @param alias - Plugin alias to resolve
     * @returns Resolved plugin name
     * @private
     */
    private resolvePluginAlias(alias?: string): string {
        alias = alias || this.defaultPlugin

        // Special case: 'flasher' is aliased to 'theme.flasher'
        return alias === 'flasher' ? 'theme.flasher' : alias
    }

    /**
     * Adds CSS and JavaScript assets to the page.
     *
     * This method efficiently loads assets, respecting the order for scripts
     * which is crucial for libraries with dependencies like jQuery plugins.
     *
     * @param assets - Array of assets to load
     * @returns Promise that resolves when all assets are loaded
     * @private
     */
    private async addAssets(assets: Asset[]): Promise<void> {
        try {
            // Process CSS files in parallel (order doesn't matter for CSS)
            const styleAssets = assets.filter((asset) => asset.type === 'style')
            const stylePromises: Promise<void>[] = []

            for (const { urls, nonce, type } of styleAssets) {
                if (!urls?.length) {
                    continue
                }

                for (const url of urls) {
                    if (!url || this.loadedAssets.has(url)) {
                        continue
                    }
                    stylePromises.push(this.loadAsset(url, nonce, type))
                    this.loadedAssets.add(url)
                }
            }

            // Load all styles in parallel
            await Promise.all(stylePromises)

            // Process script files sequentially to respect dependency order
            const scriptAssets = assets.filter((asset) => asset.type === 'script')

            for (const { urls, nonce, type } of scriptAssets) {
                if (!urls?.length) {
                    continue
                }

                // Load each script URL in the order provided
                for (const url of urls) {
                    if (!url || this.loadedAssets.has(url)) {
                        continue
                    }
                    // Wait for each script to load before proceeding to the next
                    await this.loadAsset(url, nonce, type)
                    this.loadedAssets.add(url)
                }
            }
        } catch (error) {
            console.error('PHPFlasher: Error loading assets', error)
        }
    }

    /**
     * Loads a single asset (CSS or JavaScript) into the document.
     *
     * @param url - URL of the asset to load
     * @param nonce - CSP nonce for the asset
     * @param type - Type of asset ('style' or 'script')
     * @returns Promise that resolves when the asset is loaded
     * @private
     */
    private loadAsset(url: string, nonce: string, type: 'style' | 'script'): Promise<void> {
        // Check if asset is already loaded
        if (document.querySelector(`${type === 'style' ? 'link' : 'script'}[src="${url}"]`)) {
            return Promise.resolve()
        }

        return new Promise((resolve, reject) => {
            const element = document.createElement(type === 'style' ? 'link' : 'script') as HTMLLinkElement & HTMLScriptElement

            if (type === 'style') {
                element.rel = 'stylesheet'
                element.href = url
            } else {
                element.type = 'text/javascript'
                element.src = url
            }

            // Apply CSP nonce if provided
            if (nonce) {
                element.setAttribute('nonce', nonce)
            }

            // Set up load handlers
            element.onload = () => resolve()
            element.onerror = () => reject(new Error(`Failed to load ${url}`))

            // Add to document
            document.head.appendChild(element)
        })
    }

    /**
     * Adds theme styles to the list of assets to load.
     *
     * This method extracts style URLs from theme definitions and adds them
     * to the response styles array.
     *
     * @param response - Response object to modify
     * @param plugin - Plugin name that may reference a theme
     * @private
     */
    private addThemeStyles(response: Response, plugin: string): void {
        // Only process theme plugins
        if (plugin !== 'flasher' && !plugin.includes('theme.')) {
            return
        }

        const themeName = plugin.replace('theme.', '')
        const theme = this.themes.get(themeName)
        if (!theme?.styles) {
            return
        }

        // Convert single style to array if needed
        const themeStyles = Array.isArray(theme.styles) ? theme.styles : [theme.styles]

        // Add styles without duplicates
        response.styles = Array.from(new Set([...response.styles, ...themeStyles]))
    }
}
