import { AbstractPlugin, Envelope, Options } from '@flasher/flasher';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.min.css';
type SwalType = typeof Swal;
export default class SweetAlertPlugin extends AbstractPlugin {
    sweetalert?: SwalType;
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
}
export {};
//# sourceMappingURL=sweetalert.d.ts.map