import { Envelope, Options, Theme } from './types';
import { AbstractPlugin } from './plugin';
export default class FlasherPlugin extends AbstractPlugin {
    private theme;
    private options;
    constructor(theme: Theme);
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
    private createContainer;
    private addToContainer;
    private appendNotification;
    private removeNotification;
    private handleClick;
    private renderProgressBar;
    private applyDarkMode;
    private stringToHTML;
}
//# sourceMappingURL=flasher-plugin.d.ts.map