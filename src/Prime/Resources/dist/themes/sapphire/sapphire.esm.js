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

const sapphireTheme = {
    render: (envelope) => {
        const { type, message } = envelope;
        return `
            <div class="${CLASS_NAMES.theme('sapphire')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="${CLASS_NAMES.content}">
                    <span class="${CLASS_NAMES.message}">${message}</span>
                </div>
                <div class="${CLASS_NAMES.progressBar}">
                    <div class="${CLASS_NAMES.progress}"></div>
                </div>
            </div>`;
    },
};

flasher.addTheme('sapphire', sapphireTheme);
