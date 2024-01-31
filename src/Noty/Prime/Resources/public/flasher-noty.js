(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('@flasher/flasher'), require('noty')) :
    typeof define === 'function' && define.amd ? define(['@flasher/flasher', 'noty'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.noty = factory(global.flasher, global.Noty));
})(this, (function (flasher, Noty) { 'use strict';

    class NotyPlugin extends flasher.AbstractPlugin {
        renderEnvelopes(envelopes) {
            envelopes.forEach((envelope) => {
                const options = Object.assign({ text: envelope.message, type: envelope.type }, envelope.options);
                const noty = new Noty(options);
                noty.show();
                noty.layoutDom.dataset.turboCache = 'false';
            });
        }
        renderOptions(options) {
            Noty.overrideDefaults(Object.assign({ timeout: options.timeout || 5000 }, options));
        }
    }

    const noty = new NotyPlugin();
    flasher.flasher.addPlugin('noty', noty);

    return noty;

}));
//# sourceMappingURL=flasher-noty.js.map
