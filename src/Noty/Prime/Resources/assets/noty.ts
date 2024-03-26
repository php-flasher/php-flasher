import { AbstractPlugin, Envelope, Options } from '@flasher/flasher';

import Noty, { Type } from 'noty';
import 'noty/lib/noty.css';
import 'noty/lib/themes/mint.css';

export default class NotyPlugin extends AbstractPlugin {
  public renderEnvelopes(envelopes: Envelope[]): void {
    envelopes.forEach((envelope) => {
      const options: Noty.Options = {
        text: envelope.message,
        type: envelope.type as Type,
        ...envelope.options,
      };

      const noty = new Noty(options);
      noty.show();
      // @ts-ignore
      noty.layoutDom.dataset.turboCache = 'false';
    });
  }

  public renderOptions(options: Options): void {
    Noty.overrideDefaults({
      timeout: options.timeout || 5000,
      ...options,
    });
  }
}
