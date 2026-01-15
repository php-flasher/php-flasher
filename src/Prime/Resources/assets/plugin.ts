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
        let normalizedType: string
        let normalizedMessage: string
        let normalizedTitle: string | undefined
        let normalizedOptions: Options = {}

        if (typeof type === 'object') {
            normalizedOptions = { ...type }
            normalizedType = normalizedOptions.type as string
            normalizedMessage = normalizedOptions.message as string
            normalizedTitle = normalizedOptions.title as string

            delete normalizedOptions.type
            delete normalizedOptions.message
            delete normalizedOptions.title
        } else if (typeof message === 'object') {
            normalizedOptions = { ...message }
            normalizedType = type
            normalizedMessage = normalizedOptions.message as string
            normalizedTitle = normalizedOptions.title as string

            delete normalizedOptions.message
            delete normalizedOptions.title
        } else {
            normalizedType = type
            normalizedMessage = message as string

            if (title === undefined || title === null) {
                normalizedTitle = undefined
                normalizedOptions = options || {}
            } else if (typeof title === 'string') {
                normalizedTitle = title
                normalizedOptions = options || {}
            } else if (typeof title === 'object') {
                normalizedOptions = { ...title }

                if ('title' in normalizedOptions) {
                    normalizedTitle = normalizedOptions.title as string
                    delete normalizedOptions.title
                } else {
                    normalizedTitle = undefined
                }

                if (options && typeof options === 'object') {
                    normalizedOptions = { ...normalizedOptions, ...options }
                }
            }
        }

        if (!normalizedType) {
            throw new Error('Type is required for notifications')
        }

        if (normalizedMessage === undefined || normalizedMessage === null) {
            throw new Error('Message is required for notifications')
        }

        if (normalizedTitle === undefined || normalizedTitle === null) {
            normalizedTitle = normalizedType.charAt(0).toUpperCase() + normalizedType.slice(1)
        }

        const envelope: Envelope = {
            type: normalizedType,
            message: normalizedMessage,
            title: normalizedTitle,
            options: normalizedOptions,
            metadata: {
                plugin: '',
            },
        }

        this.renderOptions({})
        this.renderEnvelopes([envelope])
    }
}
