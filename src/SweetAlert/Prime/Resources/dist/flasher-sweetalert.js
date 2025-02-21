(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('@flasher/flasher'), require('sweetalert2')) :
    typeof define === 'function' && define.amd ? define(['@flasher/flasher', 'sweetalert2'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.sweetalert = factory(global.flasher, global.Swal));
})(this, (function (flasher, Swal) { 'use strict';

    function __awaiter(thisArg, _arguments, P, generator) {
      function adopt(value) {
        return value instanceof P ? value : new P(function (resolve) {
          resolve(value);
        });
      }
      return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) {
          try {
            step(generator.next(value));
          } catch (e) {
            reject(e);
          }
        }
        function rejected(value) {
          try {
            step(generator["throw"](value));
          } catch (e) {
            reject(e);
          }
        }
        function step(result) {
          result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected);
        }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
      });
    }
    typeof SuppressedError === "function" ? SuppressedError : function (error, suppressed, message) {
      var e = new Error(message);
      return e.name = "SuppressedError", e.error = error, e.suppressed = suppressed, e;
    };

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

    class SweetAlertPlugin extends AbstractPlugin {
        renderEnvelopes(envelopes) {
            return __awaiter(this, void 0, void 0, function* () {
                for (const envelope of envelopes) {
                    yield this.renderEnvelope(envelope);
                }
            });
        }
        renderOptions(options) {
            this.sweetalert = this.sweetalert || Swal.mixin(Object.assign({ timer: (options.timer || 5000), timerProgressBar: (options.timerProgressBar || true) }, options));
            document.addEventListener('turbo:before-cache', () => {
                var _a;
                if (Swal.isVisible()) {
                    (_a = Swal.getPopup()) === null || _a === void 0 ? void 0 : _a.style.setProperty('animation-duration', '0ms');
                    Swal.close();
                }
            });
        }
        renderEnvelope(envelope) {
            return __awaiter(this, void 0, void 0, function* () {
                var _a;
                let { options } = envelope;
                options = Object.assign(Object.assign({}, options), { icon: ((options === null || options === void 0 ? void 0 : options.icon) || envelope.type), text: ((options === null || options === void 0 ? void 0 : options.text) || envelope.message) });
                yield ((_a = this.sweetalert) === null || _a === void 0 ? void 0 : _a.fire(options).then((promise) => {
                    window.dispatchEvent(new CustomEvent('flasher:sweetalert:promise', { detail: {
                            promise,
                            envelope,
                        } }));
                }));
            });
        }
    }

    const sweetalert = new SweetAlertPlugin();
    flasher.addPlugin('sweetalert', sweetalert);

    return sweetalert;

}));
