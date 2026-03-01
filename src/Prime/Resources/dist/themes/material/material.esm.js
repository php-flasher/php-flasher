/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
import flasher from '@flasher/flasher';

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
const DEFAULT_TEXT = {
    dismissButton: 'DISMISS'};

const materialTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        return `
            <div class="${CLASS_NAMES.theme('material')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-md-card">
                    <div class="${CLASS_NAMES.content}">
                        <div class="fl-text-content">
                            <div class="${CLASS_NAMES.message}">${message}</div>
                        </div>
                    </div>
                    <div class="${CLASS_NAMES.actions}">
                        <button class="fl-action-button ${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                            ${DEFAULT_TEXT.dismissButton}
                        </button>
                    </div>
                </div>
                <div class="${CLASS_NAMES.progressBar}">
                    <div class="${CLASS_NAMES.progress}"></div>
                </div>
            </div>`;
    },
};

flasher.addTheme('material', materialTheme);
