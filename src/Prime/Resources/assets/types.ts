/**
 * @file PHPFlasher Type Definitions
 * @description Core types and interfaces for the PHPFlasher notification system.
 * @author Younes ENNAJI
 */
import type { Properties } from 'csstype'

/**
 * Generic options object used throughout the application.
 *
 * This type represents a collection of key-value pairs that can be passed
 * to customize the behavior of notifications.
 *
 * @example
 * ```typescript
 * const options: Options = {
 *   timeout: 5000,
 *   position: 'top-right',
 *   closeOnClick: true
 * };
 * ```
 */
export type Options = Record<string, unknown>

/**
 * Context data that can be passed to notifications.
 *
 * Context provides additional data that can be utilized by notification
 * templates or handling logic.
 *
 * @example
 * ```typescript
 * const context: Context = {
 *   userId: 123,
 *   requestId: 'abc-123',
 *   csrfToken: 'xyz'
 * };
 * ```
 */
export type Context = Record<string, unknown>

/**
 * Represents a notification message to be displayed.
 *
 * An envelope encapsulates all the information needed to render a notification,
 * including its content, type, styling options, and metadata.
 *
 * @example
 * ```typescript
 * const envelope: Envelope = {
 *   message: 'Operation completed successfully',
 *   title: 'Success',
 *   type: 'success',
 *   options: { timeout: 5000 },
 *   metadata: { plugin: 'toastr' }
 * };
 * ```
 */
export type Envelope = {
    /** The main content of the notification */
    message: string

    /**
     * Optional title for the notification.
     * If not provided, defaults to the capitalized notification type.
     */
    title: string

    /**
     * Notification type that determines its appearance and behavior.
     * Common types include: success, error, info, warning
     */
    type: string

    /**
     * Additional configuration options specific to this notification.
     * These will override global and plugin-specific defaults.
     */
    options: Options

    /**
     * Metadata about the notification, including which plugin should handle it.
     * The plugin field determines which renderer will process this notification.
     */
    metadata: {
        plugin: string
        [key: string]: unknown
    }

    /**
     * Optional context data accessible during notification rendering.
     * This can contain request-specific information or user data.
     */
    context?: Context
}

/**
 * Response from the server containing notifications and configuration.
 *
 * This structure is typically returned from backend endpoints and contains
 * all the information needed to render notifications, including assets to load.
 *
 * @example
 * ```typescript
 * const response: Response = {
 *   envelopes: [{ message: 'Success', title: 'Done', type: 'success', options: {}, metadata: { plugin: 'toastr' } }],
 *   options: { toastr: { closeButton: true } },
 *   scripts: ['/assets/toastr.min.js'],
 *   styles: ['/assets/toastr.min.css'],
 *   context: { csp_nonce: 'random123' }
 * };
 * ```
 */
export type Response = {
    /** Array of notification envelopes to be displayed */
    envelopes: Envelope[]

    /**
     * Plugin-specific options that should be applied globally.
     * Organized by plugin name for selective application.
     */
    options: Record<string, Options>

    /** JavaScript files that should be loaded */
    scripts: string[]

    /** CSS files that should be loaded */
    styles: string[]

    /** Global context data shared across all notifications */
    context: Context
}

/**
 * Core interface that all notification plugins must implement.
 *
 * This interface defines the contract for any notification library integration.
 * Each plugin represents a different notification library (Toastr, SweetAlert, etc.)
 * but exposes the same consistent API.
 *
 * @example
 * ```typescript
 * class MyCustomPlugin implements PluginInterface {
 *   // Implementation of required methods
 * }
 *
 * // Usage
 * const plugin = new MyCustomPlugin();
 * plugin.success('Operation completed');
 * ```
 */
export interface PluginInterface {
    /**
     * Display a success notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     *
     * @example
     * ```typescript
     * // Simple usage
     * plugin.success('Data saved successfully');
     *
     * // With title
     * plugin.success('Changes applied', 'Success');
     *
     * // With options
     * plugin.success('Profile updated', 'Success', { timeOut: 3000 });
     *
     * // Using object syntax
     * plugin.success({
     *   message: 'Operation completed',
     *   title: 'Success',
     *   timeout: 5000
     * });
     * ```
     */
    success: (message: string | Options, title?: string | Options, options?: Options) => void

    /**
     * Display an error notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     *
     * @example
     * ```typescript
     * // Simple usage
     * plugin.error('An error occurred while processing your request');
     *
     * // With title
     * plugin.error('Could not connect to server', 'Connection Error');
     *
     * // With options
     * plugin.error('Invalid form data', 'Validation Error', { timeOut: 0 });
     * ```
     */
    error: (message: string | Options, title?: string | Options, options?: Options) => void

    /**
     * Display an information notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     *
     * @example
     * ```typescript
     * // Simple usage
     * plugin.info('Your session will expire in 5 minutes');
     *
     * // With title and options
     * plugin.info('New updates are available', 'Information', {
     *   closeButton: true,
     *   timeOut: 10000
     * });
     * ```
     */
    info: (message: string | Options, title?: string | Options, options?: Options) => void

    /**
     * Display a warning notification.
     *
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     *
     * @example
     * ```typescript
     * // Simple usage
     * plugin.warning('You have unsaved changes');
     *
     * // With title
     * plugin.warning('Your subscription will expire soon', 'Warning');
     * ```
     */
    warning: (message: string | Options, title?: string | Options, options?: Options) => void

    /**
     * Display any type of notification.
     *
     * This is a generic method that allows displaying notifications of any type,
     * including custom types beyond the standard success/error/info/warning.
     *
     * @param type - Notification type or options object
     * @param message - Notification content or options object
     * @param title - Optional title or options object
     * @param options - Optional configuration options
     *
     * @example
     * ```typescript
     * // Custom notification type
     * plugin.flash('question', 'Do you want to continue?', 'Confirmation');
     *
     * // Using object syntax
     * plugin.flash({
     *   type: 'custom',
     *   message: 'Something happened',
     *   title: 'Notice',
     *   icon: 'bell'
     * });
     * ```
     */
    flash: (type: string | Options, message: string | Options, title?: string | Options, options?: Options) => void

    /**
     * Render multiple notification envelopes.
     *
     * This is typically used internally to process batches of notifications
     * received from the server.
     *
     * @param envelopes - Array of notification envelopes to render
     */
    renderEnvelopes: (envelopes: Envelope[]) => void

    /**
     * Apply plugin-specific options.
     *
     * This method configures the underlying notification library
     * with the provided options.
     *
     * @param options - Configuration options for the plugin
     */
    renderOptions: (options: Options) => void
}

/**
 * Theme configuration for rendering notifications.
 *
 * A theme defines how notifications are visually presented to users,
 * including HTML structure, styling, and asset dependencies.
 *
 * @example
 * ```typescript
 * const bootstrapTheme: Theme = {
 *   styles: ['bootstrap-notifications.css'],
 *   render: (envelope) => `
 *     <div class="alert alert-${envelope.type}">
 *       <strong>${envelope.title}</strong>
 *       <p>${envelope.message}</p>
 *     </div>
 *   `
 * };
 * ```
 */
export type Theme = {
    /**
     * CSS styles to apply (string URL or array of URLs).
     * These will be automatically loaded when the theme is used.
     */
    styles?: string | string[]

    /**
     * Render function that converts an envelope to HTML string.
     * This function is responsible for generating the HTML structure
     * of the notification.
     *
     * @param envelope - The notification envelope to render
     * @returns HTML string representation of the notification
     */
    render: (envelope: Envelope) => string
}

/**
 * Asset types that can be loaded dynamically.
 * Used to distinguish between scripts and stylesheets.
 */
export type AssetType = 'style' | 'script'

/**
 * Configuration for an asset to be loaded.
 * Contains all information needed to load external resources.
 */
export type Asset = {
    /** URLs to load */
    urls: string[]

    /** Content Security Policy nonce (if required) */
    nonce: string

    /** Type of asset (style or script) */
    type: AssetType
}

/**
 * FlasherPlugin specific options.
 *
 * These options control the behavior and appearance of notifications
 * rendered by the default FlasherPlugin.
 *
 * @example
 * ```typescript
 * const options: FlasherPluginOptions = {
 *   position: 'bottom-left',
 *   timeout: 8000,
 *   rtl: true,
 *   fps: 60
 * };
 * ```
 */
export type FlasherPluginOptions = {
    /**
     * Default timeout in milliseconds (0 for no timeout).
     * Set to null to use type-specific timeouts.
     */
    timeout: number | boolean | null

    /** Type-specific timeouts in milliseconds */
    timeouts: Record<string, number>

    /** Animation frames per second for the progress bar */
    fps: number

    /**
     * Notification position on screen.
     * Common values: 'top-right', 'top-left', 'bottom-right', 'bottom-left', 'center'
     */
    position: string

    /**
     * Stacking direction of notifications.
     * 'top' means newer notifications appear above older ones.
     * 'bottom' means newer notifications appear below older ones.
     */
    direction: 'top' | 'bottom'

    /** Right-to-left text direction for RTL languages */
    rtl: boolean

    /** Custom CSS styles applied to the notification container */
    style: Properties

    /** Whether to escape HTML in messages for security */
    escapeHtml: boolean
}
