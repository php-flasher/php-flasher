import { Envelope, Options, Theme } from './types';
import { AbstractPlugin } from './plugin';
import "./themes/root.scss";
export default class FlasherPlugin extends AbstractPlugin {
    private theme;
    private options;
    constructor(theme: Theme);
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
    private createContainer;
    private addToContainer;
    private removeNotification;
    private stringToHTML;
}
