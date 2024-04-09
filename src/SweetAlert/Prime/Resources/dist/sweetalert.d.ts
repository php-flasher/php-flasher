import { AbstractPlugin } from '@flasher/flasher/dist/plugin';
import type { Envelope, Options } from '@flasher/flasher/dist/types';
import Swal from 'sweetalert2';
type SwalType = typeof Swal;
export default class SweetAlertPlugin extends AbstractPlugin {
    sweetalert?: SwalType;
    renderEnvelopes(envelopes: Envelope[]): Promise<void>;
    renderOptions(options: Options): void;
    private renderEnvelope;
}
export {};
