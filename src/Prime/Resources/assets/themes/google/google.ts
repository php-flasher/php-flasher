/**
 * @file PHPFlasher Google Theme Implementation
 * @description Material Design-inspired notification theme
 * @author Younes ENNAJI
 */
import './google.scss'
import type { Envelope } from '../../types'

/**
 * Google Material Design-inspired notification theme for PHPFlasher.
 *
 * This theme replicates Google's Material Design aesthetics with:
 * - Elevated card component with proper shadow depth
 * - Material Design iconography
 * - Google's typography system with Roboto font
 * - Material "ink ripple" effect on buttons
 * - UPPERCASE action buttons following Material guidelines
 * - Smooth animation with Material Design's motion patterns
 *
 * The theme follows Material Design specifications for components like
 * cards, buttons, typography and iconography, creating a familiar experience
 * for users of Google products.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { googleTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('google', googleTheme);
 *
 * // Use the theme
 * flasher.use('theme.google').success('Operation completed successfully');
 * ```
 */
export const googleTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates a Google Material Design-style notification with icon, title (optional),
     * message, dismissal button, and progress indicator.
     *
     * @param envelope - The notification envelope to render
     * @returns HTML string representation of the notification
     */
    render: (envelope: Envelope): string => {
        const { type, message, title } = envelope

        // Set appropriate ARIA roles based on notification type
        const isAlert = type === 'error' || type === 'warning'
        const role = isAlert ? 'alert' : 'status'
        const ariaLive = isAlert ? 'assertive' : 'polite'

        // Action button text in Material Design style (uppercase)
        const actionText = 'DISMISS'

        /**
         * Gets the appropriate Material Design icon based on notification type.
         * Each icon follows Google's Material Design iconography guidelines.
         *
         * @returns SVG markup for the notification icon
         */
        const getIcon = () => {
            switch (type) {
                case 'success':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>`
                case 'error':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                    </svg>`
                case 'warning':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                    </svg>`
                case 'info':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>`
            }
            return ''
        }

        // Generate title section if title is provided
        const titleSection = title ? `<div class="fl-title">${title}</div>` : ''

        return `
            <div class="fl-google fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-md-card">
                    <div class="fl-content">
                        <div class="fl-icon-wrapper">
                            ${getIcon()}
                        </div>
                        <div class="fl-text-content">
                            ${titleSection}
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
