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

    const slackTheme = {
        render: (envelope) => {
            const { type, message } = envelope;
            const isAlert = type === 'error' || type === 'warning';
            const role = isAlert ? 'alert' : 'status';
            const ariaLive = isAlert ? 'assertive' : 'polite';
            const getTypeIcon = () => {
                switch (type) {
                    case 'success':
                        return `<div class="fl-type-icon fl-success-icon">✓</div>`;
                    case 'error':
                        return `<div class="fl-type-icon fl-error-icon">✕</div>`;
                    case 'warning':
                        return `<div class="fl-type-icon fl-warning-icon">!</div>`;
                    case 'info':
                        return `<div class="fl-type-icon fl-info-icon">i</div>`;
                }
                return '';
            };
            return `
            <div class="fl-slack fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-slack-message">
                    <div class="fl-avatar">
                        ${getTypeIcon()}
                    </div>
                    <div class="fl-message-content">
                        <div class="fl-message-text">${message}</div>
                    </div>
                    <div class="fl-actions">
                        <button class="fl-close" aria-label="Close ${type} message">
                            <svg viewBox="0 0 20 20" width="16" height="16">
                                <path fill="currentColor" d="M10 8.586L6.707 5.293a1 1 0 00-1.414 1.414L8.586 10l-3.293 3.293a1 1 0 101.414 1.414L10 11.414l3.293 3.293a1 1 0 001.414-1.414L11.414 10l3.293-3.293a1 1 0 00-1.414-1.414L10 8.586z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>`;
        },
    };

    flasher.addTheme('slack', slackTheme);

}));
