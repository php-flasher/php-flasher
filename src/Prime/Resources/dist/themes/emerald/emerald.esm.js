/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

const emeraldTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        const isAlert = type === 'error' || type === 'warning';
        const role = isAlert ? 'alert' : 'status';
        const ariaLive = isAlert ? 'assertive' : 'polite';
        return `
            <div class="fl-emerald fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-message">${message}</div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
            </div>`;
    },
};

flasher.addTheme('emerald', emeraldTheme);
