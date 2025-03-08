/**
 * @file PHPFlasher Minimal Theme Implementation
 * @description Ultra-clean notification design that stays out of the way
 * @author Younes ENNAJI
 */
import './minimal.scss'
import type { Envelope } from '../../types'

/**
 * Minimal notification theme for PHPFlasher.
 *
 * The Minimal theme provides an ultra-clean, distraction-free design with:
 * - Translucent background with subtle blur effect
 * - Small dot indicator instead of large icons
 * - Compact dimensions and comfortable spacing
 * - Subtle entrance animation
 * - Thin progress indicator
 * - System font stack for maximum readability
 *
 * This theme is designed to be as unobtrusive as possible, perfect for
 * applications where notifications should provide information without
 * disrupting the user experience.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { minimalTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('minimal', minimalTheme);
 *
 * // Use the theme
 * flasher.use('theme.minimal').success('Changes saved');
 * ```
 */
export const minimalTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a clean, minimal notification with just the essential elements:
     * - Message text
     * - Close button
     * - Progress indicator
     *
     * The Minimal theme uses a color dot indicator instead of large icons,
     * keeping the design compact and focused on the message content.
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
            <div class="fl-minimal fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-message">${message}</div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`
    },
}
