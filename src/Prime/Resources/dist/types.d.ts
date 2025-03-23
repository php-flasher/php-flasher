import type { Properties } from 'csstype';
export type Options = Record<string, unknown>;
export type Context = Record<string, unknown>;
export type Envelope = {
    message: string;
    title: string;
    type: string;
    options: Options;
    metadata: {
        plugin: string;
        [key: string]: unknown;
    };
    context?: Context;
};
export type Response = {
    envelopes: Envelope[];
    options: Record<string, Options>;
    scripts: string[];
    styles: string[];
    context: Context;
};
export interface PluginInterface {
    success: (message: string | Options, title?: string | Options, options?: Options) => void;
    error: (message: string | Options, title?: string | Options, options?: Options) => void;
    info: (message: string | Options, title?: string | Options, options?: Options) => void;
    warning: (message: string | Options, title?: string | Options, options?: Options) => void;
    flash: (type: string | Options, message: string | Options, title?: string | Options, options?: Options) => void;
    renderEnvelopes: (envelopes: Envelope[]) => void;
    renderOptions: (options: Options) => void;
}
export type Theme = {
    styles?: string | string[];
    render: (envelope: Envelope) => string;
};
export type AssetType = 'style' | 'script';
export type Asset = {
    urls: string[];
    nonce: string;
    type: AssetType;
};
export type FlasherPluginOptions = {
    timeout: number | boolean | null;
    timeouts: Record<string, number>;
    fps: number;
    position: string;
    direction: 'top' | 'bottom';
    rtl: boolean;
    style: Properties;
    escapeHtml: boolean;
};
