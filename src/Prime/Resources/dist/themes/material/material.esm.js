/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

const materialTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        const actionText = 'DISMISS';
        return `
            <div class="fl-material fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-md-card">
                    <div class="fl-content">
                        <div class="fl-text-content">
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

flasher.addTheme('material', materialTheme);
