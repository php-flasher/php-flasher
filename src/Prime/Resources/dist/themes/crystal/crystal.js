/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('@flasher/flasher')) :
    typeof define === 'function' && define.amd ? define(['@flasher/flasher'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.flasher));
})(this, (function (flasher) { 'use strict';

    const crystalTheme = {
        render: (envelope) => {
            const { type, message } = envelope;
            const isAlert = type === 'error' || type === 'warning';
            const role = isAlert ? 'alert' : 'status';
            const ariaLive = isAlert ? 'assertive' : 'polite';
            return `
            <div class="fl-crystal fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-text">
                        <p class="fl-message">${message}</p>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`;
        },
    };

    flasher.addTheme('crystal', crystalTheme);

}));
