/**
 * @file PHPFlasher Amber Theme Implementation
 * @description Modern, elegant notification theme with refined aesthetics
 * @author Younes ENNAJI
 */
import './amber.scss'
import type { Envelope } from '../../types'

/**
 * Amber notification theme for PHPFlasher.
 *
 * The Amber theme provides a clean, minimal design that focuses on
 * content readability while maintaining visual appeal. It features:
 * - Minimalist design with clean lines
 * - Subtle animations and transitions
 * - Built-in progress indicator
 * - Accessible structure
 * - Dark mode support
 * - RTL language support
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { amberTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('amber', amberTheme);
 *
 * // Use the theme
 * flasher.use('theme.amber').success('Your changes have been saved');
 * ```
 */
export const amberTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Generates a clean, accessible notification element with:
     * - Type-specific icon
     * - Message content
     * - Close button
     * - Progress indicator
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
            <div class="fl-amber fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-icon"></div>
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
