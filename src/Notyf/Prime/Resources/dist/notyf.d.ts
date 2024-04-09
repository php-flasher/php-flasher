import { AbstractPlugin } from '@flasher/flasher/dist/plugin';
import type { Envelope, Options } from '@flasher/flasher/dist/types';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
export default class NotyfPlugin extends AbstractPlugin {
    notyf?: Notyf;
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
}
