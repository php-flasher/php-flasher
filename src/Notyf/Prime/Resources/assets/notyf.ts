import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import { Notyf } from 'notyf'
import type { INotyfOptions } from 'notyf/notyf.options'
import 'notyf/notyf.min.css'

export default class NotyfPlugin extends AbstractPlugin {
    private notyf?: Notyf

    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!this.notyf) {
            this.initializeNotyf()
        }

        envelopes.forEach((envelope) => {
            try {
                const options = { ...envelope, ...envelope.options }
                this.notyf?.open(options)
            } catch (error) {
                console.error('PHPFlasher Notyf: Error rendering notification', error, envelope)
            }
        })

        try {
            if (this.notyf) {
                const view = (this.notyf as unknown as { view: { container: { dataset?: DOMStringMap }; a11yContainer: { dataset?: DOMStringMap } } }).view
                const container = view.container
                const a11yContainer = view.a11yContainer

                if (container && container.dataset) {
                    container.dataset.turboTemporary = ''
                }

                if (a11yContainer && a11yContainer.dataset) {
                    a11yContainer.dataset.turboTemporary = ''
                }
            }
        } catch (error) {
            console.error('PHPFlasher Notyf: Error setting Turbo compatibility', error)
        }
    }

    public renderOptions(options: Options): void {
        if (!options) {
            return
        }

        const notyfOptions = {
            duration: options.duration || 10000,
            ...options,
        } as unknown as INotyfOptions

        notyfOptions.types = notyfOptions.types || []

        this.addTypeIfNotExists(notyfOptions.types, {
            type: 'info',
            className: 'notyf__toast--info',
            background: '#5784E5',
            icon: {
                className: 'notyf__icon--info',
                tagName: 'i',
            },
        })

        this.addTypeIfNotExists(notyfOptions.types, {
            type: 'warning',
            className: 'notyf__toast--warning',
            background: '#E3A008',
            icon: {
                className: 'notyf__icon--warning',
                tagName: 'i',
            },
        })

        this.notyf = this.notyf || new Notyf(notyfOptions)
    }

    private initializeNotyf(): void {
        if (!this.notyf) {
            this.renderOptions({
                duration: 10000,
                position: { x: 'right', y: 'top' },
                dismissible: true,
            })
        }
    }

    private addTypeIfNotExists(types: any[], newType: any): void {
        const exists = types.some((type) => type.type === newType.type)
        if (!exists) {
            types.push(newType)
        }
    }
}
