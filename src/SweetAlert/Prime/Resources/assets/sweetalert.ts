import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import type { SweetAlertOptions } from 'sweetalert2'
import Swal from 'sweetalert2'

type SwalType = typeof Swal

export default class SweetAlertPlugin extends AbstractPlugin {
    sweetalert?: SwalType

    public async renderEnvelopes(envelopes: Envelope[]): Promise<void> {
        for (const envelope of envelopes) {
            await this.renderEnvelope(envelope)
        }
    }

    public renderOptions(options: Options): void {
        this.sweetalert = this.sweetalert || Swal.mixin({
            timer: (options.timer || 5000) as unknown,
            timerProgressBar: (options.timerProgressBar || true) as unknown,
            ...options,
        } as SweetAlertOptions)

        document.addEventListener('turbo:before-cache', () => {
            if (Swal.isVisible()) {
                Swal.getPopup()?.style.setProperty('animation-duration', '0ms')
                Swal.close()
            }
        })
    }

    private async renderEnvelope(envelope: Envelope): Promise<void> {
        let { options } = envelope

        options = {
            ...options,
            icon: (options?.icon || envelope.type) as unknown[],
            text: (options?.text || envelope.message) as unknown[],
        }

        await this.sweetalert?.fire(options as SweetAlertOptions).then((promise) => {
            window.dispatchEvent(new CustomEvent('flasher:sweetalert:promise', { detail: {
                promise,
                envelope,
            } }))
        })
    }
}
