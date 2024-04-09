import type { Envelope, Options, PluginInterface } from './types'

export abstract class AbstractPlugin implements PluginInterface {
    abstract renderEnvelopes(envelopes: Envelope[]): void

    abstract renderOptions(options: Options): void

    public success(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('success', message, title, options)
    }

    public error(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('error', message, title, options)
    }

    public info(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('info', message, title, options)
    }

    public warning(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('warning', message, title, options)
    }

    public flash(type: string | Options, message: string | Options, title?: string | Options, options?: Options): void {
        if (typeof type === 'object') {
            options = type
            type = options.type as unknown as string
            message = options.message as unknown as string
            title = options.title as unknown as string
        } else if (typeof message === 'object') {
            options = message
            message = options.message as unknown as string
            title = options.title as unknown as string
        } else if (typeof title === 'object') {
            options = title
            title = options.title as unknown as string
        }

        if (undefined === message) {
            throw new Error('message option is required')
        }

        const envelope = {
            type,
            message,
            title: title || type,
            options: options || {},
            metadata: {
                plugin: '',
            },
        }

        this.renderOptions(options || {})
        this.renderEnvelopes([envelope])
    }
}
