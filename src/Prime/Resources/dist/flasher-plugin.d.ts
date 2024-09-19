import './themes/index.scss';
import type { Envelope, Options, Theme } from './types';
import { AbstractPlugin } from './plugin';
export default class FlasherPlugin extends AbstractPlugin {
    private theme;
    private options;
    constructor(theme: Theme);
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
    private createContainer;
    private addToContainer;
    addProgressBar(notification: HTMLElement, { timeout, fps }: {
        timeout: number;
        fps: number;
    }): void;
    private removeNotification;
    private stringToHTML;
    private escapeHtml;
}
