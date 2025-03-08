/**
 * @file PHPFlasher Default Theme
 * @description Theme implementation for the default PHPFlasher notification style
 * @author Younes ENNAJI
 */
import './flasher.scss'
import type { Envelope } from '../../types'

/**
 * The default PHPFlasher theme.
 *
 * This theme provides a classic bordered notification style with:
 * - Colored left border based on notification type
 * - Icon representing the notification type
 * - Title and message content
 * - Close button
 * - Progress bar for auto-dismiss
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { flasherTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme if not already registered
 * flasher.addTheme('custom-name', flasherTheme);
 *
 * // Use the theme
 * flasher.use('theme.custom-name').success('Operation completed');
 * ```
 */
export const flasherTheme = {
    /**
     * Renders an envelope as HTML.
     *
     * @param envelope - The notification envelope to render
     * @returns HTML string representation of the notification
     */
    render: (envelope: Envelope): string => {
        const { type, title, message } = envelope

        // Set appropriate ARIA roles based on notification type
        const isAlert = type === 'error' || type === 'warning'
        const role = isAlert ? 'alert' : 'status'
        const ariaLive = isAlert ? 'assertive' : 'polite'

        // Use provided title or capitalize the notification type
        const displayTitle = title || type.charAt(0).toUpperCase() + type.slice(1)

        return `
            <div class="fl-flasher fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${displayTitle}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">&times;</button>
                </div>
                <span class="fl-progress-bar">
                    <span class="fl-progress"></span>
                </span>
            </div>`
    },
}
