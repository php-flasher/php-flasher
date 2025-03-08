/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

const googleTheme = {
    render: (envelope) => {
        const { type, message, title } = envelope;
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        const actionText = 'DISMISS';
        const getIcon = () => {
            switch (type) {
                case 'success':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>`;
                case 'error':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                    </svg>`;
                case 'warning':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                    </svg>`;
                case 'info':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>`;
            }
            return '';
        };
        const titleSection = title ? `<div class="fl-title">${title}</div>` : '';
        return `
            <div class="fl-google fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-md-card">
                    <div class="fl-content">
                        <div class="fl-icon-wrapper">
                            ${getIcon()}
                        </div>
                        <div class="fl-text-content">
                            ${titleSection}
                            <div class="fl-message">${message}</div>
                        </div>
                    </div>
                    <div class="fl-actions">
                        <button class="fl-action-button fl-close" aria-label="Close ${type} message">
                            ${actionText}
                        </button>
                    </div>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`;
    },
};

flasher.addTheme('google', googleTheme);
