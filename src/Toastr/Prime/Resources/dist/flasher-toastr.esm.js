import flasher from '@flasher/flasher';
import toastr from 'toastr';

class AbstractPlugin {
  success(message, title, options) {
    this.flash('success', message, title, options);
  }
  error(message, title, options) {
    this.flash('error', message, title, options);
  }
  info(message, title, options) {
    this.flash('info', message, title, options);
  }
  warning(message, title, options) {
    this.flash('warning', message, title, options);
  }
  flash(type, message, title, options) {
    let normalizedType;
    let normalizedMessage;
    let normalizedTitle;
    let normalizedOptions = {};
    if (typeof type === 'object') {
      normalizedOptions = Object.assign({}, type);
      normalizedType = normalizedOptions.type;
      normalizedMessage = normalizedOptions.message;
      normalizedTitle = normalizedOptions.title;
      delete normalizedOptions.type;
      delete normalizedOptions.message;
      delete normalizedOptions.title;
    } else if (typeof message === 'object') {
      normalizedOptions = Object.assign({}, message);
      normalizedType = type;
      normalizedMessage = normalizedOptions.message;
      normalizedTitle = normalizedOptions.title;
      delete normalizedOptions.message;
      delete normalizedOptions.title;
    } else if (typeof title === 'object') {
      normalizedOptions = Object.assign({}, title);
      normalizedType = type;
      normalizedMessage = message;
      normalizedTitle = normalizedOptions.title;
      delete normalizedOptions.title;
    } else {
      normalizedType = type;
      normalizedMessage = message;
      normalizedTitle = title;
      normalizedOptions = options || {};
    }
    if (!normalizedType) {
      throw new Error('Type is required for notifications');
    }
    if (normalizedMessage === undefined || normalizedMessage === null) {
      throw new Error('Message is required for notifications');
    }
    const envelope = {
      type: normalizedType,
      message: normalizedMessage,
      title: normalizedTitle || normalizedType,
      options: normalizedOptions,
      metadata: {
        plugin: ''
      }
    };
    this.renderOptions(normalizedOptions);
    this.renderEnvelopes([envelope]);
  }
}

class ToastrPlugin extends AbstractPlugin {
    renderEnvelopes(envelopes) {
        if (!(envelopes === null || envelopes === void 0 ? void 0 : envelopes.length)) {
            return;
        }
        if (!this.isDependencyAvailable()) {
            return;
        }
        envelopes.forEach((envelope) => {
            try {
                const { message, title, type, options } = envelope;
                const instance = toastr[type](message, title, options);
                if (instance && instance.parent) {
                    try {
                        const parent = instance.parent();
                        if (parent && typeof parent.attr === 'function') {
                            parent.attr('data-turbo-temporary', '');
                        }
                    }
                    catch (error) {
                        console.error('PHPFlasher Toastr: Error setting Turbo compatibility', error);
                    }
                }
            }
            catch (error) {
                console.error('PHPFlasher Toastr: Error rendering notification', error, envelope);
            }
        });
    }
    renderOptions(options) {
        if (!this.isDependencyAvailable()) {
            return;
        }
        try {
            toastr.options = Object.assign({ timeOut: (options.timeOut || 10000), progressBar: (options.progressBar || true) }, options);
        }
        catch (error) {
            console.error('PHPFlasher Toastr: Error applying options', error);
        }
    }
    isDependencyAvailable() {
        const jQuery = window.jQuery || window.$;
        if (!jQuery) {
            console.error('PHPFlasher Toastr: jQuery is required but not loaded. Make sure jQuery is loaded before using Toastr.');
            return false;
        }
        return true;
    }
}

const toastrPlugin = new ToastrPlugin();
flasher.addPlugin('toastr', toastrPlugin);

export { toastrPlugin as default };
