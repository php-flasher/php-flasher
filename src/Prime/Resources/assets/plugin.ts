/**
 * @file Abstract Plugin Base Class
 * @description Base implementation shared by all notification plugins
 * @author yoeunes
 */
import type { Envelope, Options, PluginInterface } from './types'

/**
 * Base implementation of a notification plugin.
 *
 * AbstractPlugin provides default implementations for the standard notification
 * methods (success, error, info, warning) that delegate to the flash() method.
 * This reduces code duplication and ensures consistent behavior across plugins.
 *
 * Plugin implementations need only implement the abstract renderEnvelopes()
 * and renderOptions() methods to integrate with PHPFlasher.
 *
 * @example
 * ```typescript
 * class MyPlugin extends AbstractPlugin {
 *   // Required implementation
 *   renderEnvelopes(envelopes: Envelope[]): void {
 *     // Custom rendering logic
 *   }
 *
 *   renderOptions(options: Options): void {
 *     // Custom options handling
 *   }
 *
 *   // Optional: override other methods if needed
 * }
 * ```
 */
export abstract class AbstractPlugin implements PluginInterface {
    /**
     * Render multiple notification envelopes.
     *
     * Must be implemented by concrete plugins to define how notifications
     * are displayed using the specific notification library.
     *
     * @param envelopes - Array of notification envelopes to render
     */
    abstract renderEnvelopes(envelopes: Envelope[]): void

    /**
     * Apply plugin-specific options.
     *
     * Must be implemented by concrete plugins to configure the underlying
     * notification library with the provided options.
     *
     * @param options - Configuration options for the plugin
     */
    abstract renderOptions(options: Options): void

    /**
     * Display a success notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     */
    public success(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('success', message, title, options)
    }

    /**
     * Display an error notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     */
    public error(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('error', message, title, options)
    }

    /**
     * Display an information notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     */
    public info(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('info', message, title, options)
    }

    /**
     * Display a warning notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     */
    public warning(message: string | Options, title?: string | Options, options?: Options): void {
        this.flash('warning', message, title, options)
    }

    /**
     * Display any type of notification.
     *
     * This method handles different parameter formats to provide a flexible API:
     * - flash(type, message, title, options)
     * - flash(type, message, options) - title in options
     * - flash(type, options) - message and title in options
     * - flash(options) - type, message, and title in options
     *
     * @param type - Notification type or options object
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     *
     * @throws {Error} If required parameters are missing
     */
    public flash(type: string | Options, message: string | Options, title?: string | Options, options?: Options): void {
        // Handle overloaded parameters
        let normalizedType: string
        let normalizedMessage: string
        let normalizedTitle: string | undefined
        let normalizedOptions: Options = {}

        // Case: flash({type, message, title, ...options})
        if (typeof type === 'object') {
            normalizedOptions = { ...type }
            normalizedType = normalizedOptions.type as string
            normalizedMessage = normalizedOptions.message as string
            normalizedTitle = normalizedOptions.title as string

            // Remove these properties as they're now handled separately
            delete normalizedOptions.type
            delete normalizedOptions.message
            delete normalizedOptions.title
        }
        // Case: flash(type, {message, title, ...options})
        else if (typeof message === 'object') {
            normalizedOptions = { ...message }
            normalizedType = type
            normalizedMessage = normalizedOptions.message as string
            normalizedTitle = normalizedOptions.title as string

            delete normalizedOptions.message
            delete normalizedOptions.title
        }
        // Case: flash(type, message, {title, ...options})
        else if (typeof title === 'object') {
            normalizedOptions = { ...title }
            normalizedType = type
            normalizedMessage = message
            normalizedTitle = normalizedOptions.title as string

            delete normalizedOptions.title
        }
        // Case: flash(type, message, title, options)
        else {
            normalizedType = type
            normalizedMessage = message
            normalizedTitle = title
            normalizedOptions = options || {}
        }

        // Validate required parameters
        if (!normalizedType) {
            throw new Error('Type is required for notifications')
        }

        if (normalizedMessage === undefined || normalizedMessage === null) {
            throw new Error('Message is required for notifications')
        }

        // Create standardized envelope
        const envelope: Envelope = {
            type: normalizedType,
            message: normalizedMessage,
            title: normalizedTitle || normalizedType,
            options: normalizedOptions,
            metadata: {
                plugin: '',
            },
        }

        // Apply options and render the envelope
        this.renderOptions(normalizedOptions)
        this.renderEnvelopes([envelope])
    }
}
