import { Envelope, PluginInterface, Options, Response, Theme } from './types';
import { AbstractPlugin } from './plugin';
export default class Flasher extends AbstractPlugin {
    private defaultPlugin;
    private plugins;
    private themes;
    render(response: Partial<Response>): Promise<void>;
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
    addPlugin(name: string, plugin: PluginInterface): void;
    addTheme(name: string, theme: Theme): void;
    setDefault(name: string): Flasher;
    create(name: string): PluginInterface;
    private addStyles;
    private addScripts;
    private resolveResponse;
    private resolveOptions;
    private resolveFunction;
    private resolvePlugin;
    private resolvePluginAlias;
    private addAssets;
    private addThemeStyles;
}
//# sourceMappingURL=flasher.d.ts.map