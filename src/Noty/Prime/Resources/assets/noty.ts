import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import Noty from 'noty'
import type { Type } from 'noty'

export default class NotyPlugin extends AbstractPlugin {
    private defaultOptions: {
        timeout: number
        [key: string]: any
    } = {
            timeout: 10000,
        }

    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!envelopes?.length) {
            return
        }

        envelopes.forEach((envelope) => {
            try {
                const options: any = {
                    text: envelope.message,
                    type: envelope.type as Type,
                    ...this.defaultOptions,
                }

                if (envelope.options) {
                    Object.assign(options, envelope.options)
                }

                // Wrap callbacks to dispatch events
                const originalCallbacks = {
                    onShow: options.callbacks?.onShow,
                    onClick: options.callbacks?.onClick,
                    onClose: options.callbacks?.onClose,
                    onHover: options.callbacks?.onHover,
                }

                options.callbacks = {
                    ...options.callbacks,
                    onShow: () => {
                        this.dispatchEvent('flasher:noty:show', envelope)
                        originalCallbacks.onShow?.()
                    },
                    onClick: () => {
                        this.dispatchEvent('flasher:noty:click', envelope)
                        originalCallbacks.onClick?.()
                    },
                    onClose: () => {
                        this.dispatchEvent('flasher:noty:close', envelope)
                        originalCallbacks.onClose?.()
                    },
                    onHover: () => {
                        this.dispatchEvent('flasher:noty:hover', envelope)
                        originalCallbacks.onHover?.()
                    },
                }

                const noty = new Noty(options)
                noty.show()

                const layoutDom = (noty as any).layoutDom
                if (layoutDom && typeof layoutDom.dataset === 'object') {
                    layoutDom.dataset.turboTemporary = ''
                }
            } catch (error) {
                console.error('PHPFlasher Noty: Error rendering notification', error, envelope)
            }
        })
    }

    private dispatchEvent(eventName: string, envelope: Envelope): void {
        window.dispatchEvent(new CustomEvent(eventName, {
            detail: { envelope },
        }))
    }

    public renderOptions(options: Options): void {
        if (!options) {
            return
        }

        Object.assign(this.defaultOptions, options)
        Noty.overrideDefaults(this.defaultOptions)
    }
}
