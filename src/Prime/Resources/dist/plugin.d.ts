import type { Envelope, Options, PluginInterface } from './types';
export declare abstract class AbstractPlugin implements PluginInterface {
    abstract renderEnvelopes(envelopes: Envelope[]): void;
    abstract renderOptions(options: Options): void;
    success(message: string | Options, title?: string | Options, options?: Options): void;
    error(message: string | Options, title?: string | Options, options?: Options): void;
    info(message: string | Options, title?: string | Options, options?: Options): void;
    warning(message: string | Options, title?: string | Options, options?: Options): void;
    flash(type: string | Options, message: string | Options, title?: string | Options, options?: Options): void;
}
