/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

const facebookTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
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
            <div class="fl-facebook fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-fb-notification">
                    <div class="fl-icon-container">
                        ${getNotificationIcon()}
                    </div>
                    <div class="fl-content">
                        <div class="fl-message">
                            ${message}
                        </div>
                        <div class="fl-meta">
                            <span class="fl-time">${timeString}</span>
                        </div>
                    </div>
                    <div class="fl-actions">
                        <button class="fl-button fl-close" aria-label="Close ${type} message">
                            <div class="fl-button-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20">
                                    <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>`;
    },
};

flasher.addTheme('facebook', facebookTheme);
