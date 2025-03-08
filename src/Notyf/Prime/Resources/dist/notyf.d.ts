import { AbstractPlugin } from '@flasher/flasher/dist/plugin';
import type { Envelope, Options } from '@flasher/flasher/dist/types';
import 'notyf/notyf.min.css';
export default class NotyfPlugin extends AbstractPlugin {
    private notyf?;
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
    private initializeNotyf;
    private addTypeIfNotExists;
}
