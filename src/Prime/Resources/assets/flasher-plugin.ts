import './themes/index.scss'

import type { Properties } from 'csstype'
import type { Envelope, FlasherPluginOptions, Options, Theme } from './types'
import { AbstractPlugin } from './plugin'

export default class FlasherPlugin extends AbstractPlugin {
    private theme: Theme

    private options: FlasherPluginOptions = {
        timeout: null,
        timeouts: {
            success: 10000,
            info: 10000,
            error: 10000,
            warning: 10000,
        },
        fps: 30,
        position: 'top-right',
        direction: 'top',
        rtl: false,
        style: {} as Properties,
        escapeHtml: false,
    }

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
            const onDOMReady = () => {
                document.removeEventListener('DOMContentLoaded', onDOMReady)
                render()
            }
            document.addEventListener('DOMContentLoaded', onDOMReady)
        } else {
            render()
        }
    }

    public renderOptions(options: Options): void {
        if (!options) {
            return
        }
        this.options = { ...this.options, ...options }
    }

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
                    // Convert camelCase to kebab-case for CSS property names
                    const cssKey = key.replace(/([A-Z])/g, '-$1').toLowerCase()
                    container.style.setProperty(cssKey, String(value))
                }
            })

            document.body.appendChild(container)
        }

        // Mark for Turbo/Hotwire preservation if available
        container.dataset.turboTemporary = ''

        return container
    }

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

        // Add click event listener to dispatch theme events
        notification.addEventListener('click', (event) => {
            // Don't trigger if clicking the close button
            if ((event.target as HTMLElement).closest('.fl-close')) {
                return
            }
            this.dispatchClickEvents(envelope)
        })

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

        // Define event handlers so we can remove them later
        const handleMouseOut = () => {
            clearInterval(intervalId)
            intervalId = window.setInterval(updateTimer, lapse)
        }
        const handleMouseOver = () => clearInterval(intervalId)

        // Pause timer on hover
        notification.addEventListener('mouseout', handleMouseOut)
        notification.addEventListener('mouseover', handleMouseOver)

        // Store cleanup function on the element for later removal
        ;(notification as any)._flasherCleanup = () => {
            clearInterval(intervalId)
            notification.removeEventListener('mouseout', handleMouseOut)
            notification.removeEventListener('mouseover', handleMouseOver)
        }
    }

    private removeNotification(notification: HTMLElement): void {
        if (!notification) {
            return
        }

        // Clean up event listeners and timers to prevent memory leaks
        if ((notification as any)._flasherCleanup) {
            (notification as any)._flasherCleanup()
            delete (notification as any)._flasherCleanup
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

    private stringToHTML(str: string): HTMLElement {
        const template = document.createElement('template')
        template.innerHTML = str.trim()

        const element = template.content.firstElementChild
        if (!element) {
            throw new Error('PHPFlasher: Invalid HTML template - no element found')
        }

        return element as HTMLElement
    }

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

    private dispatchClickEvents(envelope: Envelope): void {
        const detail = { envelope }

        // Dispatch generic theme click event
        window.dispatchEvent(new CustomEvent('flasher:theme:click', { detail }))

        // Dispatch theme-specific click event (e.g., flasher:theme:flasher:click)
        const themeName = this.getThemeName(envelope)
        if (themeName) {
            window.dispatchEvent(new CustomEvent(`flasher:theme:${themeName}:click`, { detail }))
        }
    }

    private getThemeName(envelope: Envelope): string {
        const plugin = envelope.metadata?.plugin || ''

        // Extract theme name from plugin (e.g., 'theme.flasher' -> 'flasher')
        if (plugin.startsWith('theme.')) {
            return plugin.replace('theme.', '')
        }

        // If it's the default 'flasher' plugin, return 'flasher'
        if (plugin === 'flasher') {
            return 'flasher'
        }

        return plugin
    }
}
