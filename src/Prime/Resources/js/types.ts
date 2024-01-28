export interface Envelope {
  message: string;
  title: string;
  type: string;
  options: Options;
  metadata: {
    plugin: string;
  };
}

export interface PluginOptions {
  [plugin: string]: Options;
}

export interface Options {
  [option: string]: unknown;
}

export interface Context {
  [index: string]: unknown;
}

export interface Response {
  envelopes: Envelope[];
  options: PluginOptions;
  scripts: string[];
  styles: string[];
  context: Context;
}

export interface PluginInterface {
  success(message: string, title?: string, options?: Options): void;
  error(message: string, title?: string, options?: Options): void;
  info(message: string, title?: string, options?: Options): void;
  warning(message: string, title?: string, options?: Options): void;
  flash(type: string, message: string, title?: string, options?: Options): void;
  renderEnvelopes(envelopes: Envelope[]): void;
  renderOptions(options: Options): void;
}

export interface Theme {
  styles?: string | string[];
  render: (envelope: Envelope) => string;
}
