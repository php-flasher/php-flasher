/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

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

function getTimeString() {
    const now = new Date();
    return now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
}
const facebookTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        const getNotificationIcon = () => {
            switch (type) {
                case 'success':
                    return `<div class="fl-fb-icon fl-fb-icon-success">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/>
                        </svg>
                    </div>`;
                case 'error':
                    return `<div class="fl-fb-icon fl-fb-icon-error">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-11.5c-.69 0-1.25.56-1.25 1.25S11.31 13 12 13s1.25-.56 1.25-1.25S12.69 10.5 12 10.5zM12 9c.552 0 1-.448 1-1V7c0-.552-.448-1-1-1s-1 .448-1 1v1c0 .552.448 1 1 1z"/>
                        </svg>
                    </div>`;
                case 'warning':
                    return `<div class="fl-fb-icon fl-fb-icon-warning">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="currentColor" d="M12.865 3.00017L22.3912 19.5002C22.6674 19.9785 22.5035 20.5901 22.0252 20.8662C21.8732 20.954 21.7008 21.0002 21.5252 21.0002H2.47266C1.92037 21.0002 1.47266 20.5525 1.47266 20.0002C1.47266 19.8246 1.51886 19.6522 1.60663 19.5002L11.1329 3.00017C11.409 2.52187 12.0206 2.358 12.4989 2.63414C12.651 2.72192 12.7772 2.84815 12.865 3.00017ZM11 16.0002V18.0002H13V16.0002H11ZM11 8.00017V14.0002H13V8.00017H11Z"/>
                        </svg>
                    </div>`;
                case 'info':
                    return `<div class="fl-fb-icon fl-fb-icon-info">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm-1-5h2v-2h-2v2zm0-4h2V7h-2v4z"/>
                        </svg>
                    </div>`;
            }
            return '';
        };
        return `
            <div class="${CLASS_NAMES.theme('facebook')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-fb-notification">
                    <div class="fl-icon-container">
                        ${getNotificationIcon()}
                    </div>
                    <div class="${CLASS_NAMES.content}">
                        <div class="${CLASS_NAMES.message}">
                            ${message}
                        </div>
                        <div class="fl-meta">
                            <span class="fl-time">${getTimeString()}</span>
                        </div>
                    </div>
                    <div class="${CLASS_NAMES.actions}">
                        <button class="fl-button ${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                            <div class="fl-button-icon">
                                ${getCloseIcon({ size: 'md' })}
                            </div>
                        </button>
                    </div>
                </div>
            </div>`;
    },
};

flasher.addTheme('facebook', facebookTheme);
