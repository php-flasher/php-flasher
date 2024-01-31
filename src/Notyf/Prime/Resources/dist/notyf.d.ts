import { AbstractPlugin, Envelope, Options } from '@flasher/flasher';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
export default class NotyfPlugin extends AbstractPlugin {
    notyf?: Notyf;
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
}
//# sourceMappingURL=notyf.d.ts.map