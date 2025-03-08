/**
 * @file PHPFlasher Onyx Theme Implementation
 * @description Modern floating notifications with subtle accent elements
 * @author Younes ENNAJI
 */
import './onyx.scss'
import type { Envelope } from '../../types'

/**
 * Onyx notification theme for PHPFlasher.
 *
 * The Onyx theme provides a modern, refined visual style with:
 * - Clean, floating cards with elegant shadows
 * - Small accent dots in the corners indicating notification type
 * - Generous rounded corners for a contemporary look
 * - Smooth entrance animation with blur transition
 * - No icons, maintaining a minimal, focused design
 * - Subtle progress indicator at the bottom
 *
 * This theme creates a sophisticated appearance that integrates
 * well with modern interfaces while providing clear status information.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { onyxTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('onyx', onyxTheme);
 *
 * // Use the theme
 * flasher.use('theme.onyx').success('Your changes have been saved');
 * ```
 */
export const onyxTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a clean, modern notification with message content,
     * close button, and progress bar. The accent dots are added via CSS.
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
            <div class="fl-onyx fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
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
