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

    const flasherTheme = {
        render: (envelope) => {
            const { type, title, message } = envelope;
            const isAlert = type === 'error' || type === 'warning';
            const role = isAlert ? 'alert' : 'status';
            const ariaLive = isAlert ? 'assertive' : 'polite';
            const displayTitle = title || type.charAt(0).toUpperCase() + type.slice(1);
            return `
            <div class="fl-flasher fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${displayTitle}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">&times;</button>
                </div>
                <span class="fl-progress-bar">
                    <span class="fl-progress"></span>
                </span>
            </div>`;
        },
    };

    flasher.addTheme('flasher', flasherTheme);

}));
