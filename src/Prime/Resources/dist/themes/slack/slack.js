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

    const sizeMap = {
        sm: 16,
        md: 20,
        lg: 24,
    };
    const iconPaths = {
        success: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
        error: 'M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z',
        warning: 'M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z',
        info: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z',
        close: 'M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z',
    };
    function getIcon(type, config = {}) {
        const { size = 'md', className = '' } = config;
        const dimension = typeof size === 'number' ? size : sizeMap[size];
        const path = iconPaths[type];
        const classAttr = className ? ` class="${className}"` : '';
        return `<svg${classAttr} viewBox="0 0 24 24" width="${dimension}" height="${dimension}" aria-hidden="true"><path fill="currentColor" d="${path}"/></svg>`;
    }
    function getCloseIcon(config = {}) {
        return getIcon('close', Object.assign({ size: 'sm' }, config));
    }

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

    const TYPE_ICONS = {
        success: '✓',
        error: '✕',
        warning: '!',
        info: 'i',
    };
    const slackTheme = {
        render: (envelope) => {
            const { type, message } = envelope;
            const iconChar = TYPE_ICONS[type] || '';
            return `
            <div class="${CLASS_NAMES.theme('slack')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-slack-message">
                    <div class="fl-avatar">
                        <div class="fl-type-icon fl-${type}-icon">${iconChar}</div>
                    </div>
                    <div class="fl-message-content">
                        <div class="fl-message-text">${message}</div>
                    </div>
                    <div class="${CLASS_NAMES.actions}">
                        <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                            ${getCloseIcon()}
                        </button>
                    </div>
                </div>
            </div>`;
        },
    };

    flasher.addTheme('slack', slackTheme);

}));
