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

    function getA11yAttributes(type) {
        const isAlert = type === 'error' || type === 'warning';
        return {
            role: isAlert ? 'alert' : 'status',
            ariaLive: isAlert ? 'assertive' : 'polite',
            ariaAtomic: 'true',
        };
    }
    function getA11yString(type) {
        const attrs = getA11yAttributes(type);
        return `role="${attrs.role}" aria-live="${attrs.ariaLive}" aria-atomic="${attrs.ariaAtomic}"`;
    }
    function getCloseButtonA11y(type) {
        return `aria-label="Close ${type} message"`;
    }

    const CLASS_NAMES = {
        container: 'fl-container',
        wrapper: 'fl-wrapper',
        content: 'fl-content',
        message: 'fl-message',
        title: 'fl-title',
        text: 'fl-text',
        icon: 'fl-icon',
        iconWrapper: 'fl-icon-wrapper',
        actions: 'fl-actions',
        close: 'fl-close',
        progressBar: 'fl-progress-bar',
        progress: 'fl-progress',
        show: 'fl-show',
        sticky: 'fl-sticky',
        rtl: 'fl-rtl',
        type: (type) => `fl-${type}`,
        theme: (name) => `fl-${name}`,
    };

    const amberTheme = {
        render: (envelope) => {
            const { type, message } = envelope;
            return `
            <div class="${CLASS_NAMES.theme('amber')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="${CLASS_NAMES.content}">
                    <div class="${CLASS_NAMES.icon}"></div>
                    <div class="${CLASS_NAMES.text}">
                        <div class="${CLASS_NAMES.message}">${message}</div>
                    </div>
                    <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>×</button>
                </div>
                <div class="${CLASS_NAMES.progressBar}">
                    <div class="${CLASS_NAMES.progress}"></div>
                </div>
            </div>`;
        },
    };

    flasher.addTheme('amber', amberTheme);

}));
