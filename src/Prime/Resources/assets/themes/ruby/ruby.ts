/**
 * @file PHPFlasher Ruby Theme Implementation
 * @description Vibrant notifications with gradient backgrounds and gemstone effects
 * @author Younes ENNAJI
 */
import './ruby.scss'
import type { Envelope } from '../../types'

/**
 * Ruby notification theme for PHPFlasher.
 *
 * The Ruby theme provides a vibrant, colorful style with:
 * - Rich gradient backgrounds for each notification type
 * - Elegant shine animation reminiscent of light reflecting off gemstones
 * - Circular icon container with translucent background
 * - Clean typography with good contrast on colored backgrounds
 * - Smooth scale animation for entrance
 * - Semi-transparent progress indicator
 *
 * This theme creates an eye-catching appearance that draws attention
 * while maintaining excellent readability and a premium feel.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { rubyTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('ruby', rubyTheme);
 *
 * // Use the theme
 * flasher.use('theme.ruby').success('Your changes have been saved');
 * ```
 */
export const rubyTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a vibrant, gradient notification with shine effect,
     * circular icon container, message content, close button, and progress bar.
     *
     * @param envelope - The notification envelope to render
     * @returns HTML string representation of the notification
     */
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        // Set appropriate ARIA roles based on notification type
        const isAlert = type === 'error' || type === 'warning'
        const role = isAlert ? 'alert' : 'status'
        const ariaLive = isAlert ? 'assertive' : 'polite'

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
            </div>`
    },
}
