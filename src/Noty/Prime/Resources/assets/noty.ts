import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import type { Type } from 'noty'
import Noty from 'noty'

export default class NotyPlugin extends AbstractPlugin {
    public renderEnvelopes(envelopes: Envelope[]): void {
        envelopes.forEach((envelope) => {
            const options: Noty.Options = {
                text: envelope.message,
                type: envelope.type as Type,
                ...envelope.options,
            }

            const noty = new Noty(options)
            noty.show()
            // @ts-expect-error
            noty.layoutDom?.dataset.turboTemporary = ''
        })
    }

    public renderOptions(options: Options): void {
        Noty.overrideDefaults({
            timeout: options.timeout || 5000,
            ...options,
        })
    }
}
