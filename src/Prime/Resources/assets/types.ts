export type Options = { [option: string]: unknown }

export type Context = { [key: string]: unknown }

export type Envelope = {
    message: string
    title: string
    type: string
    options: Options
    metadata: { plugin: string }
    context?: Context
}

export type Response = {
    envelopes: Envelope[]
    options: { [plugin: string]: Options }
    scripts: string[]
    styles: string[]
    context: Context
}

export type PluginInterface = {
    success: (message: string | Options, title?: string | Options, options?: Options) => void
    error: (message: string | Options, title?: string | Options, options?: Options) => void
    info: (message: string | Options, title?: string | Options, options?: Options) => void
    warning: (message: string | Options, title?: string | Options, options?: Options) => void
    flash: (type: string | Options, message: string | Options, title?: string | Options, options?: Options) => void
    renderEnvelopes: (envelopes: Envelope[]) => void
    renderOptions: (options: Options) => void
}

export type Theme = {
    styles?: string | string[]
    render: (envelope: Envelope) => string
}
