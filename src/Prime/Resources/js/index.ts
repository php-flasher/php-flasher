import '../styles/index.scss';

import Flasher from './flasher';
import { theme } from './theme';
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

const flasher = new Flasher();
flasher.addTheme('flasher', theme);

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

declare global {
  interface Window {
    flash: Flasher;
  }
}

window.flash = flasher;
