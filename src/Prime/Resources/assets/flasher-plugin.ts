/**
 * @file FlasherPlugin Implementation
 * @description Default implementation for displaying notifications using custom themes
 * @author Younes ENNAJI
 */
import './themes/index.scss'

import type { Properties } from 'csstype'
import type { Envelope, FlasherPluginOptions, Options, Theme } from './types'
import { AbstractPlugin } from './plugin'

/**
 * Default FlasherPlugin implementation using custom themes.
 *
 * FlasherPlugin is the built-in renderer for PHPFlasher that creates DOM-based
 * notifications with a customizable appearance. It uses themes to determine
 * the HTML structure and styling of notifications.
 *
 * Features:
 * - Theme-based notification rendering
 * - Container management for different positions
 * - Auto-dismissal with progress bars
 * - RTL language support
 * - HTML escaping for security
 * - Mouse-over pause of auto-dismissal
 *
 * @example
 * ```typescript
 * // Create a simple theme
 * const myTheme: Theme = {
 *   styles: ['my-theme.css'],
 *   render: (envelope) => `
 *     <div class="my-notification my-notification-${envelope.type}">
 *       <h4>${envelope.title}</h4>
 *       <p>${envelope.message}</p>
 *       <button class="fl-close">&times;</button>
 *       <div class="fl-progress-bar"></div>
 *     </div>
 *   `
 * };
 *
 * // Create a plugin with the theme
 * const plugin = new FlasherPlugin(myTheme);
 *
 * // Show a notification
 * plugin.success('Operation completed');
 * ```
 */
export default class FlasherPlugin extends AbstractPlugin {
    /**
     * Theme configuration used for rendering notifications.
     * @private
     */
    private theme: Theme

    /**
     * Default configuration options for notifications.
     * These can be overridden globally or per notification.
     * @private
     */
    private options: FlasherPluginOptions = {
        // Default or type-specific timeout (milliseconds, null = use type-specific)
        // Use false for sticky notifications, or any negative number
        timeout: null,

        // Type-specific timeout durations
        timeouts: {
            success: 10000,
            info: 10000,
            error: 10000,
            warning: 10000,
        },

        // Animation frames per second (higher = smoother but more CPU intensive)
        fps: 30,

        // Default position on screen
        position: 'top-right',

        // Stacking direction (top = newest first, bottom = newest last)
        direction: 'top',

        // Right-to-left text direction
        rtl: false,

        // Custom container styles
        style: {} as Properties,

        // Whether to escape HTML in message content (security feature)
        escapeHtml: false,
    }

    /**
     * Creates a new FlasherPlugin with a specific theme.
     *
     * @param theme - Theme configuration to use for rendering notifications
     * @throws {Error} If theme is missing or invalid
     */
    constructor(theme: Theme) {
        super()

        if (!theme) {
            throw new Error('Theme is required')
        }

        if (typeof theme.render !== 'function') {
            throw new TypeError('Theme must have a render function')
        }

        this.theme = theme
    }

    /**
     * Renders notification envelopes using the configured theme.
     *
     * This method creates and displays notifications in the DOM based on
     * the provided envelopes and the plugin's theme.
     *
     * @param envelopes - Array of notification envelopes to render
     */
    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!envelopes?.length) {
            return
        }

        const render = () => {
            envelopes.forEach((envelope) => {
                try {
                    // Get type-specific timeout or default
                    const typeTimeout = this.options.timeout ?? this.options.timeouts[envelope.type] ?? 10000

                    // Merge default options with envelope-specific options
                    const mergedOptions = {
                        ...this.options,
                        ...envelope.options,
                        timeout: this.normalizeTimeout(envelope.options.timeout ?? typeTimeout),
                        escapeHtml: (envelope.options.escapeHtml ?? this.options.escapeHtml) as boolean,
                    }

                    // Create or get the container for this notification position
                    const container = this.createContainer(mergedOptions)

                    // Extract only the properties that addToContainer expects
                    const containerOptions = {
                        direction: mergedOptions.direction,
                        timeout: Number(mergedOptions.timeout || 0), // Convert null/undefined to 0
                        fps: mergedOptions.fps,
                        rtl: mergedOptions.rtl,
                        escapeHtml: mergedOptions.escapeHtml,
                    }

                    // Add notification to the container
                    this.addToContainer(container, envelope, containerOptions)
                } catch (error) {
                    console.error('PHPFlasher: Error rendering envelope', error, envelope)
                }
            })
        }

        // Wait for DOM to be ready if needed
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', render)
        } else {
            render()
        }
    }

    /**
     * Updates the plugin options.
     *
     * @param options - New options to apply
     */
    public renderOptions(options: Options): void {
        if (!options) {
            return
        }
        this.options = { ...this.options, ...options }
    }

    /**
     * Creates or gets the container for notifications.
     *
     * This method ensures that each position has its own container for notifications.
     * If a container for the specified position doesn't exist yet, it creates one.
     *
     * @param options - Options containing position and style information
     * @returns The container element
     * @private
     */
    private createContainer(options: { position: string, style: Properties }): HTMLDivElement {
        // Look for existing container for this position
        let container = document.querySelector(`.fl-wrapper[data-position="${options.position}"]`) as HTMLDivElement

        if (!container) {
            // Create new container if none exists
            container = document.createElement('div')
            container.className = 'fl-wrapper'
            container.dataset.position = options.position

            // Apply custom styles
            Object.entries(options.style).forEach(([key, value]) => {
                if (value !== undefined && value !== null) {
                    container.style.setProperty(key, String(value))
                }
            })

            document.body.appendChild(container)
        }

        // Mark for Turbo/Hotwire preservation if available
        container.dataset.turboTemporary = ''

        return container
    }

    /**
     * Adds a notification to the container.
     *
     * This method:
     * 1. Creates a notification element using the theme's render function
     * 2. Adds necessary classes and event listeners
     * 3. Appends it to the container in the right position
     * 4. Sets up auto-dismissal if a timeout is specified
     *
     * @param container - Container to add the notification to
     * @param envelope - Notification information
     * @param options - Display options
     * @private
     */
    private addToContainer(
        container: HTMLDivElement,
        envelope: Envelope,
        options: {
            direction: string
            timeout: number
            fps: number
            rtl: boolean
            escapeHtml: boolean
        },
    ): void {
        // Sanitize content if needed
        if (options.escapeHtml) {
            envelope.title = this.escapeHtml(envelope.title)
            envelope.message = this.escapeHtml(envelope.message)
        }

        // Create notification element from theme template
        const notification = this.stringToHTML(this.theme.render(envelope))

        // Add standard classes
        notification.classList.add('fl-container')
        if (options.rtl) {
            notification.classList.add('fl-rtl')
        }

        // Add to container in the right position (top or bottom)
        if (options.direction === 'bottom') {
            container.append(notification)
        } else {
            container.prepend(notification)
        }

        // Trigger animation on next frame for better performance
        requestAnimationFrame(() => notification.classList.add('fl-show'))

        // Add close button functionality
        const closeButton = notification.querySelector('.fl-close')
        if (closeButton) {
            closeButton.addEventListener('click', (event) => {
                event.stopPropagation()
                this.removeNotification(notification)
            })
        }

        // Add timer if timeout is greater than 0 (not sticky)
        if (options.timeout > 0) {
            this.addTimer(notification, options)
        } else {
            // For sticky notifications, we might want to add a class
            notification.classList.add('fl-sticky')

            // For sticky notifications with progress bar, set it to full width
            const progressBarContainer = notification.querySelector('.fl-progress-bar')
            if (progressBarContainer) {
                // Create progress bar element that stays at 100%
                const progressBar = document.createElement('span')
                progressBar.classList.add('fl-progress', 'fl-sticky-progress')
                progressBar.style.width = '100%'
                progressBarContainer.append(progressBar)
            }
        }
    }

    /**
     * Normalizes timeout value to handle different formats (number, boolean, null)
     *
     * @param timeout - The timeout value to normalize
     * @returns A number representing milliseconds, or 0 for sticky notifications
     * @private
     */
    private normalizeTimeout(timeout: any): number {
        // Handle false or negative numbers as sticky notifications (0)
        if (timeout === false || (typeof timeout === 'number' && timeout < 0)) {
            return 0
        }

        // Handle null or undefined
        if (timeout == null) {
            return 0
        }

        // Convert to number (handles string numbers too)
        return Number(timeout) || 0
    }

    /**
     * Adds a progress timer to the notification.
     *
     * This method creates a visual progress bar that shows the remaining time
     * before auto-dismissal. The timer pauses when the user hovers over the notification.
     *
     * @param notification - Notification element
     * @param options - Timer options
     * @private
     */
    private addTimer(notification: HTMLElement, { timeout, fps }: { timeout: number, fps: number }): void {
        if (timeout <= 0) {
            return
        }

        const lapse = 1000 / fps
        let elapsed = 0
        let intervalId: number

        const updateTimer = () => {
            elapsed += lapse

            const progressBarContainer = notification.querySelector('.fl-progress-bar')
            if (progressBarContainer) {
                // Create or get progress bar element
                let progressBar = progressBarContainer.querySelector('.fl-progress')
                if (!progressBar) {
                    progressBar = document.createElement('span')
                    progressBar.classList.add('fl-progress')
                    progressBarContainer.append(progressBar)
                }

                // Calculate and set progress (decreasing from 100% to 0%)
                const percent = (1 - elapsed / timeout) * 100;
                (progressBar as HTMLElement).style.width = `${Math.max(0, percent)}%`
            }

            // Close notification when time is up
            if (elapsed >= timeout) {
                clearInterval(intervalId)
                this.removeNotification(notification)
            }
        }

        // Start timer
        intervalId = window.setInterval(updateTimer, lapse)

        // Pause timer on hover
        notification.addEventListener('mouseout', () => {
            clearInterval(intervalId)
            intervalId = window.setInterval(updateTimer, lapse)
        })
        notification.addEventListener('mouseover', () => clearInterval(intervalId))
    }

    /**
     * Removes a notification with animation.
     *
     * This method:
     * 1. Removes the 'show' class to trigger the hide animation
     * 2. Waits for the animation to complete
     * 3. Removes the notification from the DOM
     * 4. Cleans up the container if it's now empty
     *
     * @param notification - Notification element to remove
     * @private
     */
    private removeNotification(notification: HTMLElement): void {
        if (!notification) {
            return
        }

        notification.classList.remove('fl-show')

        // Clean up empty containers after animation
        notification.ontransitionend = () => {
            const parent = notification.parentElement
            notification.remove()

            if (parent && !parent.hasChildNodes()) {
                parent.remove()
            }
        }
    }

    /**
     * Converts an HTML string to a DOM element.
     *
     * @param str - HTML string to convert
     * @returns The created DOM element
     * @private
     */
    private stringToHTML(str: string): HTMLElement {
        const template = document.createElement('template')
        template.innerHTML = str.trim()
        return template.content.firstElementChild as HTMLElement
    }

    /**
     * Safely escapes HTML special characters.
     *
     * This method replaces special characters with their HTML entities
     * to prevent XSS attacks when displaying user-provided content.
     *
     * @param str - String to escape
     * @returns Escaped string
     * @private
     */
    private escapeHtml(str: string | null | undefined): string {
        if (str == null) {
            return ''
        }

        const htmlEscapes: Record<string, string> = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            '\'': '&#39;',
            '`': '&#96;',
            '=': '&#61;',
            '/': '&#47;',
        }

        return str.replace(/[&<>"'`=/]/g, (char) => htmlEscapes[char] || char)
    }
}
