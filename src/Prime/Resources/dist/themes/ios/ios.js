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

    const iosTheme = {
        render: (envelope) => {
            const { type, message, title } = envelope;
            const isAlert = type === 'error' || type === 'warning';
            const role = isAlert ? 'alert' : 'status';
            const ariaLive = isAlert ? 'assertive' : 'polite';
            const appName = 'PHPFlasher';
            const now = new Date();
            const timeString = now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
            const getIcon = () => {
                switch (type) {
                    case 'success':
                        return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>`;
                    case 'error':
                        return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>`;
                    case 'warning':
                        return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>`;
                    case 'info':
                        return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>`;
                }
                return '';
            };
            const displayTitle = title || appName;
            return `
            <div class="fl-ios fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-ios-notification">
                    <div class="fl-header">
                        <div class="fl-app-icon">
                            ${getIcon()}
                        </div>
                        <div class="fl-app-info">
                            <div class="fl-app-name">${displayTitle}</div>
                            <div class="fl-time">${timeString}</div>
                        </div>
                    </div>
                    <div class="fl-content">
                        <div class="fl-message">${message}</div>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>`;
        },
    };

    flasher.addTheme('ios', iosTheme);

}));
