/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
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
        } else {
          normalizedType = type;
          normalizedMessage = message;
          if (title === undefined || title === null) {
            normalizedTitle = undefined;
            normalizedOptions = options || {};
          } else if (typeof title === 'string') {
            normalizedTitle = title;
            normalizedOptions = options || {};
          } else if (typeof title === 'object') {
            normalizedOptions = Object.assign({}, title);
            if ('title' in normalizedOptions) {
              normalizedTitle = normalizedOptions.title;
              delete normalizedOptions.title;
            } else {
              normalizedTitle = undefined;
            }
            if (options && typeof options === 'object') {
              normalizedOptions = Object.assign(Object.assign({}, normalizedOptions), options);
            }
          }
        }
        if (!normalizedType) {
          throw new Error('Type is required for notifications');
        }
        if (normalizedMessage === undefined || normalizedMessage === null) {
          throw new Error('Message is required for notifications');
        }
        if (normalizedTitle === undefined || normalizedTitle === null) {
          normalizedTitle = normalizedType.charAt(0).toUpperCase() + normalizedType.slice(1);
        }
        const envelope = {
          type: normalizedType,
          message: normalizedMessage,
          title: normalizedTitle,
          options: normalizedOptions,
          metadata: {
            plugin: ''
          }
        };
        this.renderOptions({});
        this.renderEnvelopes([envelope]);
      }
    }

    class SweetAlertPlugin extends AbstractPlugin {
        renderEnvelopes(envelopes) {
            return __awaiter(this, void 0, void 0, function* () {
                if (!this.sweetalert) {
                    this.initializeSweetAlert();
                }
                try {
                    for (const envelope of envelopes) {
                        yield this.renderEnvelope(envelope);
                    }
                }
                catch (error) {
                    console.error('PHPFlasher SweetAlert: Error rendering envelopes', error);
                }
            });
        }
        renderOptions(options) {
            try {
                this.sweetalert = this.sweetalert || Swal.mixin(Object.assign({ timer: (options.timer || 10000), timerProgressBar: (options.timerProgressBar || true) }, options));
                this.setupTurboCompatibility();
            }
            catch (error) {
                console.error('PHPFlasher SweetAlert: Error applying options', error);
            }
        }
        renderEnvelope(envelope) {
            return __awaiter(this, void 0, void 0, function* () {
                var _a;
                try {
                    let { options } = envelope;
                    options = Object.assign(Object.assign({}, options), { icon: ((options === null || options === void 0 ? void 0 : options.icon) || envelope.type), text: ((options === null || options === void 0 ? void 0 : options.text) || envelope.message) });
                    const promise = yield ((_a = this.sweetalert) === null || _a === void 0 ? void 0 : _a.fire(options));
                    this.dispatchResultEvent(promise, envelope);
                }
                catch (error) {
                    console.error('PHPFlasher SweetAlert: Error rendering envelope', error, envelope);
                }
            });
        }
        initializeSweetAlert() {
            if (!this.sweetalert) {
                this.renderOptions({
                    timer: 10000,
                    timerProgressBar: true,
                });
            }
        }
        setupTurboCompatibility() {
            document.addEventListener('turbo:before-cache', () => {
                if (Swal.isVisible()) {
                    const popup = Swal.getPopup();
                    if (popup) {
                        popup.style.setProperty('animation-duration', '0ms');
                    }
                    Swal.close();
                }
            });
        }
        dispatchResultEvent(promise, envelope) {
            if (promise) {
                window.dispatchEvent(new CustomEvent('flasher:sweetalert:promise', {
                    detail: {
                        promise,
                        envelope,
                    },
                }));
            }
        }
    }

    const sweetalert = new SweetAlertPlugin();
    flasher.addPlugin('sweetalert', sweetalert);

    return sweetalert;

}));
