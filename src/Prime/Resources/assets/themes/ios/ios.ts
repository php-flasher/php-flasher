/**
 * @file PHPFlasher iOS Theme Implementation
 * @description Apple iOS-style notification interface
 * @author Younes ENNAJI
 */
import './ios.scss'
import type { Envelope } from '../../types'

/**
 * iOS-inspired notification theme for PHPFlasher.
 *
 * This theme replicates Apple's iOS notification style with:
 * - Frosted glass appearance with backdrop blur
 * - App icon and name header
 * - Current time display
 * - Subtle animations and transitions
 * - Close button in iOS style
 * - Full dark mode support (resembles iOS dark mode)
 *
 * The theme aims to provide a native-like experience for users familiar with
 * iOS devices, creating notifications that feel integrated with the platform.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import { iosTheme } from '@flasher/flasher/themes';
 *
 * // Register the theme (if not already registered)
 * flasher.addTheme('ios', iosTheme);
 *
 * // Use the theme
 * flasher.use('theme.ios').success('Your photo was uploaded successfully');
 * ```
 */
export const iosTheme = {
    /**
     * Renders a notification envelope as HTML.
     *
     * Creates an iOS-style notification with app icon, title/app name,
     * timestamp, message content, and close button.
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

        // Default app name (used if no title is provided)
        const appName = 'PHPFlasher'

        // Format current time in iOS style (hour:minute)
        const now = new Date()
        const timeString = now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })

        /**
         * Gets the appropriate icon based on notification type.
         * Each type has a specific icon matching iOS visual style.
         *
         * @returns SVG markup for the notification icon
         */
        const getIcon = () => {
            switch (type) {
                case 'success':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>`
                case 'error':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>`
                case 'warning':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>`
                case 'info':
                    return `<svg class="fl-icon-svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>`
            }
            return ''
        }

        // Use provided title or default to the app name
        const displayTitle = title || appName

        return `
            <div class="fl-ios fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-ios-notification">
                    <div class="fl-header">
                        <div class="fl-app-icon">
                            ${getIcon()}
                        </div>
                        <div class="fl-app-info">
                            <div class="fl-app-name">${displayTitle}</div>
                            <div class="fl-time">${timeString}</div>
                        </div>
                    </div>
                    <div class="fl-content">
                        <div class="fl-message">${message}</div>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>`
    },
}
