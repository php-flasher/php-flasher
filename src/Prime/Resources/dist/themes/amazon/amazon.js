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

    const amazonTheme = {
        render: (envelope) => {
            const { type, message } = envelope;
            const isAlert = type === 'error' || type === 'warning';
            const role = isAlert ? 'alert' : 'status';
            const ariaLive = isAlert ? 'assertive' : 'polite';
            const getAlertIcon = () => {
                switch (type) {
                    case 'success':
                        return `<svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>`;
                    case 'error':
                        return `<svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>`;
                    case 'warning':
                        return `<svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>`;
                    case 'info':
                        return `<svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>`;
                }
                return '';
            };
            const getAlertTitle = () => {
                switch (type) {
                    case 'success': return 'Success!';
                    case 'error': return 'Problem';
                    case 'warning': return 'Warning';
                    case 'info': return 'Information';
                    default: return 'Alert';
                }
            };
            return `
            <div class="fl-amazon fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-amazon-alert">
                    <div class="fl-alert-content">
                        <div class="fl-icon-container">
                            ${getAlertIcon()}
                        </div>
                        <div class="fl-text-content">
                            <div class="fl-alert-title">${getAlertTitle()}</div>
                            <div class="fl-alert-message">${message}</div>
                        </div>
                    </div>
                    <div class="fl-alert-actions">
                        <button class="fl-close" aria-label="Close notification">
                            <svg viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>`;
        },
    };

    flasher.addTheme('amazon', amazonTheme);

}));
