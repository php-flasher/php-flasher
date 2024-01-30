import '../styles/index.scss';
import Flasher from './flasher';
import { AbstractPlugin } from './plugin';
import { Context, Envelope, Options, PluginInterface, PluginOptions, Response, Theme } from './types';
declare const flasher: Flasher;
export { flasher, AbstractPlugin, Context, Envelope, Options, PluginInterface, PluginOptions, Response, Theme, };
declare global {
    interface Window {
        flash: Flasher;
    }
}
//# sourceMappingURL=index.d.ts.map