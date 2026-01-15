import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import type { SweetAlertOptions, SweetAlertResult } from 'sweetalert2'
import Swal from 'sweetalert2'

type SwalType = typeof Swal

export default class SweetAlertPlugin extends AbstractPlugin {
    private sweetalert?: SwalType

    public async renderEnvelopes(envelopes: Envelope[]): Promise<void> {
        if (!this.sweetalert) {
            this.initializeSweetAlert()
        }

        try {
            for (const envelope of envelopes) {
                await this.renderEnvelope(envelope)
            }
        } catch (error) {
            console.error('PHPFlasher SweetAlert: Error rendering envelopes', error)
        }
    }

    public renderOptions(options: Options): void {
        try {
            this.sweetalert = this.sweetalert || Swal.mixin({
                timer: (options.timer || 10000) as unknown,
                timerProgressBar: (options.timerProgressBar || true) as unknown,
                ...options,
            } as SweetAlertOptions)

            this.setupTurboCompatibility()
        } catch (error) {
            console.error('PHPFlasher SweetAlert: Error applying options', error)
        }
    }

    private async renderEnvelope(envelope: Envelope): Promise<void> {
        try {
            let { options } = envelope

            options = {
                ...options,
                icon: (options?.icon || envelope.type) as unknown,
                text: (options?.text || envelope.message) as unknown,
            }

            const promise = await this.sweetalert?.fire(options as SweetAlertOptions)
            this.dispatchResultEvent(promise, envelope)
        } catch (error) {
            console.error('PHPFlasher SweetAlert: Error rendering envelope', error, envelope)
        }
    }

    private initializeSweetAlert(): void {
        if (!this.sweetalert) {
            this.renderOptions({
                timer: 10000,
                timerProgressBar: true,
            })
        }
    }

    private setupTurboCompatibility(): void {
        document.addEventListener('turbo:before-cache', () => {
            if (Swal.isVisible()) {
                const popup = Swal.getPopup()
                if (popup) {
                    popup.style.setProperty('animation-duration', '0ms')
                }

                Swal.close()
            }
        })
    }

    private dispatchResultEvent(
        promise: SweetAlertResult<any> | undefined,
        envelope: Envelope,
    ): void {
        if (promise) {
            window.dispatchEvent(new CustomEvent('flasher:sweetalert:promise', {
                detail: {
                    promise,
                    envelope,
                },
            }))
        }
    }
}
