/**
 * @file PHPFlasher Slack Theme Implementation
 * @description Notifications styled after Slack's messaging interface
 * @author Younes ENNAJI
 */
import './slack.scss'
import type { Envelope } from '../../types'

/**
 * Slack notification theme for PHPFlasher.
 *
 * The Slack theme replicates the familiar messaging interface from Slack with:
 * - Message bubbles with subtle borders and shadows
 * - Avatar-like colored icons indicating notification type
 * - Clean typography matching Slack's text style
 * - Hover effects that reveal action buttons
 * - Simple, fast animations for a responsive feel
 *
 * This theme creates a familiar experience for users accustomed to Slack's
 * widely-used interface, providing a sense of comfort and familiarity.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { slackTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('slack', slackTheme);
 *
 * // Use the theme
 * flasher.use('theme.slack').success('Your changes have been saved');
 * ```
 */
export const slackTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a Slack-styled message bubble with colored avatar icon,
     * message text, and a close button that appears on hover.
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

        /**
         * Gets the appropriate type icon based on notification type.
         * Each type has a simple symbol within a colored background.
         *
         * @returns HTML markup for the type icon
         */
        const getTypeIcon = () => {
            switch (type) {
                case 'success':
                    return `<div class="fl-type-icon fl-success-icon">✓</div>`
                case 'error':
                    return `<div class="fl-type-icon fl-error-icon">✕</div>`
                case 'warning':
                    return `<div class="fl-type-icon fl-warning-icon">!</div>`
                case 'info':
                    return `<div class="fl-type-icon fl-info-icon">i</div>`
            }
            return ''
        }

        return `
            <div class="fl-slack fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-slack-message">
                    <div class="fl-avatar">
                        ${getTypeIcon()}
                    </div>
                    <div class="fl-message-content">
                        <div class="fl-message-text">${message}</div>
                    </div>
                    <div class="fl-actions">
                        <button class="fl-close" aria-label="Close ${type} message">
                            <svg viewBox="0 0 20 20" width="16" height="16">
                                <path fill="currentColor" d="M10 8.586L6.707 5.293a1 1 0 00-1.414 1.414L8.586 10l-3.293 3.293a1 1 0 101.414 1.414L10 11.414l3.293 3.293a1 1 0 001.414-1.414L11.414 10l3.293-3.293a1 1 0 00-1.414-1.414L10 8.586z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>`
    },
}
