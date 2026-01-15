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

    public renderOptions(options: Options): void {
        if (!options) {
            return
        }

        Object.assign(this.defaultOptions, options)
        Noty.overrideDefaults(this.defaultOptions)
    }
}
