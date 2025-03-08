/**
 * @file PHPFlasher Aurora Theme Implementation
 * @description Calm, soothing notification style with glass morphism effects
 * @author Younes ENNAJI
 */
import './aurora.scss'
import type { Envelope } from '../../types'

/**
 * Aurora notification theme for PHPFlasher.
 *
 * The Aurora theme provides an elegant, modern glass-like appearance with:
 * - Translucent background with backdrop blur
 * - Subtle gradients based on notification type
 * - Soft rounded corners and delicate shadows
 * - Minimalist design that focuses on content
 * - Smooth animation with subtle scaling
 * - Accessible structure and interactions
 *
 * This theme is inspired by modern glass/frosted UI design patterns found in
 * iOS and macOS, providing a contemporary feel that works well in both light
 * and dark modes.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { auroraTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('aurora', auroraTheme);
 *
 * // Use the theme
 * flasher.use('theme.aurora').success('Your profile has been updated');
 * ```
 */
export const auroraTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a minimal, elegant notification with just the essential elements:
     * - Message text
     * - Close button
     * - Progress indicator
     *
     * The aurora theme deliberately omits icons to maintain its clean aesthetic,
     * relying instead on subtle color gradients to indicate notification type.
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
            <div class="fl-aurora fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
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
