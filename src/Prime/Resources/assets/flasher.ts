import { Envelope, PluginInterface, Options, Response, Theme, Context } from './types';
import { AbstractPlugin } from './plugin';
import FlasherPlugin from './flasher-plugin';

type AssetTagElement = HTMLLinkElement & HTMLScriptElement & { [attrName: string]: string };

export default class Flasher extends AbstractPlugin {
    private defaultPlugin = 'flasher';
    private plugins: Map<string, PluginInterface> = new Map<string, PluginInterface>();
    private themes: Map<string, Theme> = new Map<string, Theme>();

    public async render(response: Partial<Response>): Promise<void> {
        const resolved = this.resolveResponse(response);

        await this.addAssets([
            { urls: resolved.styles, nonce: resolved.context.csp_style_nonce as string, type: 'style' },
            { urls: resolved.scripts, nonce: resolved.context.csp_script_nonce as string, type: 'script' },
        ]);

        this.renderOptions(resolved.options);
        this.renderEnvelopes(resolved.envelopes);
    }

    public renderEnvelopes(envelopes: Envelope[]): void {
        const map: Record<string, Envelope[]> = {};

        envelopes.forEach((envelope) => {
            const plugin = this.resolvePluginAlias(envelope.metadata.plugin);

            map[plugin] = map[plugin] || [];
            map[plugin].push(envelope);
        });

        Object.entries(map).forEach(([plugin, envelopes]) => {
            this.create(plugin).renderEnvelopes(envelopes);
        });
    }

    public renderOptions(options: Options): void {
        Object.entries(options).forEach(([plugin, option]) => {
            // @ts-ignore
            this.create(plugin).renderOptions(option);
        });
    }

    public addPlugin(name: string, plugin: PluginInterface): void {
        this.plugins.set(name, plugin);
    }

    public addTheme(name: string, theme: Theme): void {
        this.themes.set(name, theme);
    }

    public create(name: string): PluginInterface {
        name = this.resolvePluginAlias(name);
        this.resolvePlugin(name);

        const plugin = this.plugins.get(name);
        if (!plugin) {
            throw new Error(`Unable to resolve "${name}" plugin, did you forget to register it?`);
        }

        return plugin;
    }

    private resolveResponse(response: Partial<Response>): Response {
        const resolved = { envelopes: [], options: {}, scripts: [], styles: [], context: {}, ...response} as Response;

        Object.entries(resolved.options).forEach(([plugin, options]) => {
            resolved.options[plugin] = this.resolveOptions(options);
        });

        resolved.context.csp_style_nonce = resolved.context.csp_style_nonce || '';
        resolved.context.csp_script_nonce = resolved.context.csp_script_nonce || '';

        resolved.envelopes.forEach((envelope) => {
            envelope.metadata = envelope.metadata || {};
            envelope.metadata.plugin = this.resolvePluginAlias(envelope.metadata.plugin);
            this.addThemeStyles(resolved, envelope.metadata.plugin);
            envelope.options = this.resolveOptions(envelope.options);
            envelope.context = response.context as Context;
        });

        return resolved;
    }

    private resolveOptions(options: Options): Options {
        Object.entries(options).forEach(([key, value]) => {
            options[key] = this.resolveFunction(value);
        });

        return options;
    }

    private resolveFunction(func: unknown): unknown {
        if (typeof func !== 'string') {
            return func;
        }

        const match = func.match(/^function(?:.+)?(?:\s+)?\((.+)?\)(?:\s+|\n+)?{(?:\s+|\n+)?((?:.|\n)+)}$/m);

        if (!match) {
            return func;
        }

        const args = match[1]?.split(',').map((arg) => arg.trim()) ?? [];
        const body = match[2];

        return new Function(...args, body);
    }

    private resolvePlugin(alias: string): void {
        const factory = this.plugins.get(alias);
        if (factory || !alias.includes('theme.')) {
            return;
        }

        const view = this.themes.get(alias.replace('theme.', ''));
        if (!view) {
            return;
        }

        this.addPlugin(alias, new FlasherPlugin(view));
    }

    private resolvePluginAlias(alias?: string): string {
        alias = alias || this.defaultPlugin;

        return 'flasher' === alias ? 'theme.flasher' : alias;
    }

    private async addAssets(assets: Array<{ urls: string[], nonce: string, type: 'style' | 'script' }>): Promise<void> {
        for (const { urls, nonce, type } of assets) {
            await Promise.all(urls.map(url => this.loadAsset(url, nonce, type)));
        }
    }

    private async loadAsset(url: string, nonce: string, type: 'style' | 'script'): Promise<void> {
        if (document.querySelector(`${type === 'style' ? 'link' : 'script'}[src="${url}"]`)) {
            return;
        }

        const element = document.createElement(type === 'style' ? 'link' : 'script') as AssetTagElement;
        if (type === 'style') {
            element.rel = 'stylesheet';
            element.href = url;
        } else {
            element.type = 'text/javascript';
            element.src = url;
        }

        if (nonce) element.setAttribute('nonce', nonce);
        document.head.appendChild(element);

        return new Promise((resolve, reject) => {
            element.onload = () => resolve();
            element.onerror = () => reject(new Error(`Failed to load ${url}`));
        });
    }

    private addThemeStyles(response: Response, plugin: string): void {
        if ('flasher' !== plugin && !plugin.includes('theme.')) {
            return;
        }

        plugin = plugin.replace('theme.', '');
        const styles = this.themes.get(plugin)?.styles || [];

        response.styles = Array.from(new Set([...response.styles, ...styles]));
    }
}
