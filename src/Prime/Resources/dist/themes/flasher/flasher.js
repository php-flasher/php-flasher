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
    const DEFAULT_TITLES = {
        success: 'Success',
        error: 'Error',
        warning: 'Warning',
        info: 'Information',
    };
    function capitalizeType(type) {
        return type.charAt(0).toUpperCase() + type.slice(1);
    }
    function getTitle(title, type) {
        return title || DEFAULT_TITLES[type] || capitalizeType(type);
    }

    const flasherTheme = {
        render: (envelope) => {
            const { type, title, message } = envelope;
            const displayTitle = getTitle(title, type);
            return `
            <div class="${CLASS_NAMES.theme('flasher')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="${CLASS_NAMES.content}">
                    <div class="${CLASS_NAMES.icon}"></div>
                    <div>
                        <strong class="${CLASS_NAMES.title}">${displayTitle}</strong>
                        <span class="${CLASS_NAMES.message}">${message}</span>
                    </div>
                    <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>&times;</button>
                </div>
                <span class="${CLASS_NAMES.progressBar}">
                    <span class="${CLASS_NAMES.progress}"></span>
                </span>
            </div>`;
        },
    };

    flasher.addTheme('flasher', flasherTheme);

}));
