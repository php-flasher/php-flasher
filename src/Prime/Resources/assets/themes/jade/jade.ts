/**
 * @file PHPFlasher Jade Theme Implementation
 * @description Minimalist notification theme with soft, natural aesthetics
 * @author Younes ENNAJI
 */
import './jade.scss'
import type { Envelope } from '../../types'

/**
 * Jade notification theme for PHPFlasher.
 *
 * The Jade theme provides a clean, minimal aesthetic with:
 * - Soft, pastel color palette inspired by natural tones
 * - Generous border radius for a friendly appearance
 * - Subtle entrance animation with scale and fade
 * - Type-specific colored backgrounds and text
 * - Minimalist layout without icons for a clean look
 * - Refined hover interactions and transitions
 *
 * This theme prioritizes readability and calmness, making it
 * ideal for applications where subtle notifications are preferred.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { jadeTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('jade', jadeTheme);
 *
 * // Use the theme
 * flasher.use('theme.jade').success('Your changes have been saved');
 * ```
 */
export const jadeTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a clean, minimal notification with just the essential elements:
     * - Message text
     * - Close button
     * - Progress indicator
     *
     * The Jade theme deliberately omits icons and titles for a more streamlined
     * appearance, focusing purely on the message content.
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
            <div class="fl-jade fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
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
