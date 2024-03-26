import '../styles/index.scss';

import Flasher from './flasher';
import { AbstractPlugin } from './plugin';
import {
  Context,
  Envelope,
  Options,
  PluginInterface,
  PluginOptions,
  Response,
  Theme,
} from './types';

import { flasherTheme } from './themes/flasher';

declare global {
    interface Window {
        flash: Flasher;
    }
}

const flasher = new Flasher();

flasher.addTheme('flasher', flasherTheme);

window.flash = flasher;

export {
  flasher,
  AbstractPlugin,
  Context,
  Envelope,
  Options,
  PluginInterface,
  PluginOptions,
  Response,
  Theme,
};
