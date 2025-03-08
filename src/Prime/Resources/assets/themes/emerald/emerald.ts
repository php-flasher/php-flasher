/**
 * @file PHPFlasher Emerald Theme Implementation
 * @description Elegant glass-like notification theme with bounce animation
 * @author Younes ENNAJI
 */
import './emerald.scss'
import type { Envelope } from '../../types'

/**
 * Emerald notification theme for PHPFlasher.
 *
 * The Emerald theme provides an elegant, glass-like notification style with:
 * - Translucent background with backdrop blur effect
 * - Distinctive bounce animation on entrance
 * - Colored text based on notification type
 * - Clean and modern typography
 * - Minimalistic design with focus on readability
 * - No progress bar for a cleaner appearance
 *
 * This theme is named "Emerald" for its polished, refined appearance that
 * gives notifications a gem-like quality.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { emeraldTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('emerald', emeraldTheme);
 *
 * // Use the theme
 * flasher.use('theme.emerald').success('Your changes have been saved');
 * ```
 */
export const emeraldTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a minimal, elegant notification without icons or progress bars
     * for a clean look. Focuses solely on the message and close button.
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
            <div class="fl-emerald fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-message">${message}</div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
            </div>`
    },
}
