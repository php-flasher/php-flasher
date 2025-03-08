/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

const rubyTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        return `
            <div class="fl-ruby fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-shine"></div>
                <div class="fl-content">
                    <div class="fl-icon-circle">
                        <div class="fl-icon"></div>
                    </div>
                    <div class="fl-text">
                        <div class="fl-message">${message}</div>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`;
    },
};

flasher.addTheme('ruby', rubyTheme);
