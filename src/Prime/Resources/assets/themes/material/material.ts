/**
 * @file PHPFlasher Material Design Theme Implementation
 * @description Minimalist Material Design notification theme
 * @author Younes ENNAJI
 */
import './material.scss'
import type { Envelope } from '../../types'

/**
 * Material Design notification theme for PHPFlasher.
 *
 * This theme implements Google's Material Design principles with a minimalist approach:
 * - Clean card design with proper elevation shadow
 * - Material Design typography with Roboto font
 * - UPPERCASE action button following Material guidelines
 * - Material "ink ripple" effect on button press
 * - Material motion patterns for animations
 * - Linear progress indicator
 *
 * Unlike the more comprehensive Google theme, this Material theme
 * provides a simpler, more streamlined appearance without icons,
 * focusing purely on the message content.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { materialTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('material', materialTheme);
 *
 * // Use the theme
 * flasher.use('theme.material').success('Operation completed successfully');
 * ```
 */
export const materialTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a minimalist Material Design notification card with
     * message content, dismiss button, and progress indicator.
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

        // Material Design uses uppercase text for buttons
        const actionText = 'DISMISS'

        return `
            <div class="fl-material fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-md-card">
                    <div class="fl-content">
                        <div class="fl-text-content">
                            <div class="fl-message">${message}</div>
                        </div>
                    </div>
                    <div class="fl-actions">
                        <button class="fl-action-button fl-close" aria-label="Close ${type} message">
                            ${actionText}
                        </button>
                    </div>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`
    },
}
