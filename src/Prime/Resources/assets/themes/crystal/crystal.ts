/**
 * @file PHPFlasher Crystal Theme Implementation
 * @description Clean, elegant notification theme with subtle animations
 * @author Younes ENNAJI
 */
import './crystal.scss'
import type { Envelope } from '../../types'

/**
 * Crystal notification theme for PHPFlasher.
 *
 * The Crystal theme provides a clean, elegant design with distinct features:
 * - Monochromatic design with colored text for each notification type
 * - Subtle entrance animation
 * - Gentle pulsing shadow effect on hover
 * - Minimalist structure that emphasizes message content
 * - Smooth transitions and animations
 * - Accessible structure and interactions
 *
 * This theme aims to be understated yet elegant, providing notifications
 * that are noticeable without being distracting.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { crystalTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('crystal', crystalTheme);
 *
 * // Use the theme
 * flasher.use('theme.crystal').success('Document saved successfully');
 * ```
 */
export const crystalTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a clean, elegant notification with minimal elements:
     * - Message text
     * - Close button
     * - Progress indicator
     *
     * The Crystal theme uses colored text rather than backgrounds to indicate
     * notification type, creating a more subtle visual distinction.
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
            <div class="fl-crystal fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-text">
                        <p class="fl-message">${message}</p>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`
    },
}
