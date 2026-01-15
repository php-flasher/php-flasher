import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import toastr from 'toastr'

export default class ToastrPlugin extends AbstractPlugin {
    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!envelopes?.length) {
            return
        }

        if (!this.isDependencyAvailable()) {
            return
        }

        envelopes.forEach((envelope) => {
            try {
                const { message, title, type, options } = envelope

                const instance = toastr[type as ToastrType](message, title, options as ToastrOptions)

                if (instance && instance.parent) {
                    try {
                        const parent = instance.parent()
                        if (parent && typeof parent.attr === 'function') {
                            parent.attr('data-turbo-temporary', '')
                        }
                    } catch (error) {
                        console.error('PHPFlasher Toastr: Error setting Turbo compatibility', error)
                    }
                }
            } catch (error) {
                console.error('PHPFlasher Toastr: Error rendering notification', error, envelope)
            }
        })
    }

    public renderOptions(options: Options): void {
        if (!this.isDependencyAvailable()) {
            return
        }

        try {
            toastr.options = {
                timeOut: (options.timeOut || 10000) as number,
                progressBar: (options.progressBar || true) as boolean,
                ...options,
            } as ToastrOptions
        } catch (error) {
            console.error('PHPFlasher Toastr: Error applying options', error)
        }
    }

    private isDependencyAvailable(): boolean {
        const jQuery = window.jQuery || window.$

        if (!jQuery) {
            console.error('PHPFlasher Toastr: jQuery is required but not loaded. Make sure jQuery is loaded before using Toastr.')
            return false
        }

        return true
    }
}
