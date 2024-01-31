(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('@flasher/flasher'), require('notyf')) :
    typeof define === 'function' && define.amd ? define(['@flasher/flasher', 'notyf'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.notyf = factory(global.flasher, global.notyf$1));
})(this, (function (flasher, notyf$1) { 'use strict';

    class NotyfPlugin extends flasher.AbstractPlugin {
        renderEnvelopes(envelopes) {
            envelopes.forEach((envelope) => {
                var _a;
                const options = Object.assign(Object.assign({}, envelope), envelope.options);
                (_a = this.notyf) === null || _a === void 0 ? void 0 : _a.open(options);
            });
            this.notyf.view.container.dataset.turboCache = 'false';
            this.notyf.view.a11yContainer.dataset.turboCache = 'false';
        }
        renderOptions(options) {
            const nOptions = Object.assign({ duration: options.duration || 5000 }, options);
            nOptions.types = nOptions.types || [];
            nOptions.types.push({
                type: 'info',
                className: 'notyf__toast--info',
                background: '#5784E5',
                icon: {
                    className: 'notyf__icon--info',
                    tagName: 'i',
                },
            });
            nOptions.types.push({
                type: 'warning',
                className: 'notyf__toast--warning',
                background: '#E3A008',
                icon: {
                    className: 'notyf__icon--warning',
                    tagName: 'i',
                },
            });
            this.notyf = this.notyf || new notyf$1.Notyf(nOptions);
        }
    }

    const notyf = new NotyfPlugin();
    flasher.flasher.addPlugin('notyf', notyf);

    return notyf;

}));
//# sourceMappingURL=flasher-notyf.js.map
