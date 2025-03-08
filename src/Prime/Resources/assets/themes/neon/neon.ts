/**
 * @file PHPFlasher Neon Theme Implementation
 * @description Elegant notifications with subtle glowing accents
 * @author Younes ENNAJI
 */
import './neon.scss'
import type { Envelope } from '../../types'

/**
 * Neon notification theme for PHPFlasher.
 *
 * The Neon theme provides an elegant visual style with:
 * - Subtle glowing accents based on notification type
 * - Floating illuminated circular indicator
 * - Frosted glass background with blur effect
 * - Refined typography using Inter font
 * - Smooth entrance animation with blur transition
 * - Gentle pulsing glow effect on the indicator
 *
 * This theme creates a modern, sophisticated appearance with a touch
 * of futuristic design through its subtle illumination effects.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { neonTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('neon', neonTheme);
 *
 * // Use the theme
 * flasher.use('theme.neon').success('Your changes have been saved');
 * ```
 */
export const neonTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates an elegant notification with a glowing indicator,
     * message content, close button, and progress bar.
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
            <div class="fl-neon fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
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
