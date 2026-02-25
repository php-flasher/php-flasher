import type { Asset, Context, Envelope, Options, PluginInterface, Response, Theme } from './types'
import { AbstractPlugin } from './plugin'
import FlasherPlugin from './flasher-plugin'

export default class Flasher extends AbstractPlugin {
    private defaultPlugin = 'flasher'
    private plugins: Map<string, PluginInterface> = new Map<string, PluginInterface>()
    private themes: Map<string, Theme> = new Map<string, Theme>()
    private loadedAssets: Set<string> = new Set<string>()

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

    public addPlugin(name: string, plugin: PluginInterface): void {
        if (!name || !plugin) {
            throw new Error('Both plugin name and instance are required')
        }
        this.plugins.set(name, plugin)
    }

    public addTheme(name: string, theme: Theme): void {
        if (!name || !theme) {
            throw new Error('Both theme name and definition are required')
        }
        this.themes.set(name, theme)
    }

    public use(name: string): PluginInterface {
        const resolvedName = this.resolvePluginAlias(name)
        this.resolvePlugin(resolvedName)

        const plugin = this.plugins.get(resolvedName)
        if (!plugin) {
            throw new Error(`Unable to resolve "${resolvedName}" plugin, did you forget to register it?`)
        }

        return plugin
    }

    public create(name: string): PluginInterface {
        return this.use(name)
    }

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
            envelope.context = resolved.context
        })

        return resolved
    }

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

    private resolveFunction(func: unknown): unknown {
        if (typeof func !== 'string') {
            return func
        }

        const functionRegex = /^function\s*(\w*)\s*\(([^)]*)\)\s*\{([\s\S]*)\}$/
        const arrowFunctionRegex = /^\s*(\(([^)]*)\)|[^=]+)\s*=>\s*([\s\S]+)$/

        const functionMatch = func.match(functionRegex)
        const arrowMatch = func.match(arrowFunctionRegex)

        if (!functionMatch && !arrowMatch) {
            return func
        }

        let args: string[]
        let body: string

        if (functionMatch) {
            // Regular function: body is already complete statements
            args = functionMatch[2]?.split(',').map((arg) => arg.trim()).filter(Boolean) ?? []
            body = functionMatch[3].trim()
        } else {
            // Arrow function: may need to wrap expression body with return
            args = arrowMatch![2]?.split(',').map((arg) => arg.trim()).filter(Boolean) ?? []
            body = arrowMatch![3].trim()

            // Arrow functions with a single expression need return added
            if (!body.startsWith('{')) {
                body = `return ${body};`
            } else {
                // Remove outer braces for arrow functions with block body
                body = body.slice(1, -1).trim()
            }
        }

        try {
            // eslint-disable-next-line no-new-func
            return new Function(...args, body)
        } catch (e) {
            console.error('PHPFlasher: Error converting string to function:', e)
            return func
        }
    }

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

    private resolvePluginAlias(alias?: string): string {
        alias = alias || this.defaultPlugin

        // Special case: 'flasher' is aliased to 'theme.flasher'
        return alias === 'flasher' ? 'theme.flasher' : alias
    }

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

    private loadAsset(url: string, nonce: string, type: 'style' | 'script'): Promise<void> {
        // Check if asset is already loaded
        const selector = type === 'style' ? `link[href="${url}"]` : `script[src="${url}"]`
        if (document.querySelector(selector)) {
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
