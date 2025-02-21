(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('@flasher/flasher'), require('noty')) :
    typeof define === 'function' && define.amd ? define(['@flasher/flasher', 'noty'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.Noty = factory(global.flasher, global.Noty));
})(this, (function (flasher, Noty) { 'use strict';

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
        if (typeof type === 'object') {
          options = type;
          type = options.type;
          message = options.message;
          title = options.title;
        } else if (typeof message === 'object') {
          options = message;
          message = options.message;
          title = options.title;
        } else if (typeof title === 'object') {
          options = title;
          title = options.title;
        }
        if (undefined === message) {
          throw new Error('message option is required');
        }
        const envelope = {
          type,
          message,
          title: title || type,
          options: options || {},
          metadata: {
            plugin: ''
          }
        };
        this.renderOptions(options || {});
        this.renderEnvelopes([envelope]);
      }
    }

    class NotyPlugin extends AbstractPlugin {
        renderEnvelopes(envelopes) {
            envelopes.forEach((envelope) => {
                var _a;
                const options = Object.assign({ text: envelope.message, type: envelope.type }, envelope.options);
                const noty = new Noty(options);
                noty.show();
                (_a = noty.layoutDom) === null || _a === void 0 ? void 0 : _a.dataset.turboTemporary = '';
            });
        }
        renderOptions(options) {
            Noty.overrideDefaults(Object.assign({ timeout: options.timeout || 5000 }, options));
        }
    }

    const noty = new NotyPlugin();
    flasher.addPlugin('noty', noty);

    return noty;

}));
