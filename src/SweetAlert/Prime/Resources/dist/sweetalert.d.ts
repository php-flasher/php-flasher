import { AbstractPlugin } from '@flasher/flasher/dist/plugin';
import type { Envelope, Options } from '@flasher/flasher/dist/types';
export default class SweetAlertPlugin extends AbstractPlugin {
    private sweetalert?;
    renderEnvelopes(envelopes: Envelope[]): Promise<void>;
    renderOptions(options: Options): void;
    private renderEnvelope;
    private initializeSweetAlert;
    private setupTurboCompatibility;
    private dispatchResultEvent;
}
