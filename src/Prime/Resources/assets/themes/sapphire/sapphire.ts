/**
 * @file PHPFlasher Sapphire Theme Implementation
 * @description Modern glassmorphic notifications with blurred backdrop effect
 * @author Younes ENNAJI
 */
import './sapphire.scss'
import type { Envelope } from '../../types'

/**
 * Sapphire notification theme for PHPFlasher.
 *
 * The Sapphire theme provides a modern, glassmorphic visual style with:
 * - Semi-transparent backgrounds with backdrop blur effect
 * - Clean, minimalist design without icons or close buttons
 * - Subtle bounce animation for entrance
 * - Type-specific colored backgrounds with high transparency
 * - Elegant progress indicator at the bottom
 *
 * This theme emphasizes simplicity and modern design trends, creating
 * a sophisticated appearance that integrates well with contemporary interfaces.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { sapphireTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('sapphire', sapphireTheme);
 *
 * // Use the theme
 * flasher.use('theme.sapphire').success('Your changes have been saved');
 * ```
 */
export const sapphireTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a clean, minimal notification with just the message content
     * and progress bar. Unlike most themes, the Sapphire theme intentionally
     * omits a close button and icons for a more streamlined appearance.
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
            <div class="fl-sapphire fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <span class="fl-message">${message}</span>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`
    },
}
