(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.flasher = {}));
})(this, (function (exports) { 'use strict';

    const flasherTheme = {
        render: (envelope) => {
            const { type, title, message } = envelope;
            return `
            <div class="fl-flasher fl-${type}">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${title}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close">&times;</button>
                </div>
            </div>`;
        },
    };

    exports.flasherTheme = flasherTheme;

}));
