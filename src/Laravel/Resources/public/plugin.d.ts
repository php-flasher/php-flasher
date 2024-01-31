import { Envelope, Options, PluginInterface } from './types';
export declare abstract class AbstractPlugin implements PluginInterface {
    abstract renderEnvelopes(envelopes: Envelope[]): void;
    abstract renderOptions(options: Options): void;
    success(message: string, title?: string, options?: Options): void;
    error(message: string, title?: string, options?: Options): void;
    info(message: string, title?: string, options?: Options): void;
    warning(message: string, title?: string, options?: Options): void;
    flash(type: string, message: string, title?: string, options?: Options): void;
}
//# sourceMappingURL=plugin.d.ts.map