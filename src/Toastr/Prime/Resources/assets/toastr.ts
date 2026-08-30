import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import toastr from 'toastr'

// @types/toastr >= 2.1.44 is a module and exports no named types,
// so the option/type shapes must be derived from the instance
type ToastrOptions = typeof toastr.options
type ToastrType = 'error' | 'info' | 'success' | 'warning'

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

                // Wrap callbacks to dispatch events
                const mergedOptions = {
                    ...options,
                    onShown: () => {
                        this.dispatchEvent('flasher:toastr:show', envelope);
                        (options as any)?.onShown?.()
                    },
                    onclick: () => {
                        this.dispatchEvent('flasher:toastr:click', envelope);
                        (options as any)?.onclick?.()
                    },
                    onCloseClick: () => {
                        this.dispatchEvent('flasher:toastr:close', envelope);
                        (options as any)?.onCloseClick?.()
                    },
                    onHidden: () => {
                        this.dispatchEvent('flasher:toastr:hidden', envelope);
                        (options as any)?.onHidden?.()
                    },
                } as ToastrOptions

                const instance = toastr[type as ToastrType](message, title, mergedOptions)

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

    private dispatchEvent(eventName: string, envelope: Envelope): void {
        window.dispatchEvent(new CustomEvent(eventName, {
            detail: { envelope },
        }))
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
