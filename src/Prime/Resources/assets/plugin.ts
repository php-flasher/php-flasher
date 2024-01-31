import { Envelope, Options, PluginInterface } from './types';

export abstract class AbstractPlugin implements PluginInterface {
  abstract renderEnvelopes(envelopes: Envelope[]): void;
  abstract renderOptions(options: Options): void;

  public success(message: string, title?: string, options?: Options): void {
    this.flash('success', message, title, options);
  }

  public error(message: string, title?: string, options?: Options): void {
    this.flash('error', message, title, options);
  }

  public info(message: string, title?: string, options?: Options): void {
    this.flash('info', message, title, options);
  }

  public warning(message: string, title?: string, options?: Options): void {
    this.flash('warning', message, title, options);
  }

  public flash(
    type: string,
    message: string,
    title?: string,
    options?: Options,
  ): void {
    const envelope = {
      type,
      message,
      title: title || type,
      options: options || {},
      metadata: {
        plugin: '',
      },
    };

    this.renderOptions(options || {});
    this.renderEnvelopes([envelope]);
  }
}
