import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import toastr from 'toastr'

export default class ToastrPlugin extends AbstractPlugin {
    public renderEnvelopes(envelopes: Envelope[]): void {
        envelopes.forEach((envelope) => {
            const { message, title, type, options } = envelope
            const instance = toastr[type as ToastrType](message, title, options as ToastrOptions)
            instance && instance.parent().attr('data-turbo-temporary', '')
        })
    }

    public renderOptions(options: Options): void {
        toastr.options = {
            timeOut: (options.timeOut || 5000) as unknown as number,
            progressBar: (options.progressBar || true) as unknown as boolean,
            ...options,
        } as ToastrOptions
    }
}
