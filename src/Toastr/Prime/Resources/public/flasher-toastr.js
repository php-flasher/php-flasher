(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('@flasher/flasher'), require('toastr')) :
    typeof define === 'function' && define.amd ? define(['@flasher/flasher', 'toastr'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.toastr = factory(global.flasher, global.toastr$1));
})(this, (function (flasher, toastr$1) { 'use strict';

    class ToastrPlugin extends flasher.AbstractPlugin {
        renderEnvelopes(envelopes) {
            envelopes.forEach((envelope) => {
                const { message, title, type, options } = envelope;
                const instance = toastr$1[type](message, title, options);
                instance && instance.parent().attr('data-turbo-cache', 'false');
            });
        }
        renderOptions(options) {
            toastr$1.options = Object.assign({ timeOut: (options.timeOut || 5000), progressBar: (options.progressBar || true) }, options);
        }
    }

    const toastr = new ToastrPlugin();
    flasher.flasher.addPlugin('toastr', toastr);

    return toastr;

}));
//# sourceMappingURL=flasher-toastr.js.map
