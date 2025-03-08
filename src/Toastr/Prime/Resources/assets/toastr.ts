/**
 * @file Toastr Plugin Implementation
 * @description PHPFlasher integration with the Toastr notification library
 * @author Younes ENNAJI
 */
import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import toastr from 'toastr'

/**
 * Plugin implementation for Toastr notification library.
 *
 * The ToastrPlugin integrates the popular Toastr library with PHPFlasher,
 * allowing for customizable toast notifications in various positions.
 *
 * This plugin requires jQuery and Toastr to be loaded in the page. These
 * dependencies are automatically loaded by the PHP plugin's getScripts method.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import ToastrPlugin from '@flasher/flasher-toastr';
 *
 * // Register the plugin
 * flasher.addPlugin('toastr', new ToastrPlugin());
 *
 * // Show a notification
 * flasher.use('toastr').success('Operation completed');
 * ```
 */
export default class ToastrPlugin extends AbstractPlugin {
    /**
     * Creates Toastr notifications from envelopes.
     *
     * This method transforms PHPFlasher envelopes into Toastr notifications
     * and displays them using the Toastr library.
     *
     * @param envelopes - Array of notification envelopes to render
     */
    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!envelopes?.length) {
            return
        }

        // Check for dependencies
        if (!this.isDependencyAvailable()) {
            return
        }

        envelopes.forEach((envelope) => {
            try {
                const { message, title, type, options } = envelope

                // Display the toast notification
                const instance = toastr[type as ToastrType](message, title, options as ToastrOptions)

                // Handle Turbo/Hotwire compatibility
                if (instance && instance.parent) {
                    try {
                        const parent = instance.parent()
                        if (parent && typeof parent.attr === 'function') {
                            parent.attr('data-turbo-temporary', '')
                        }
                    } catch (error) {
                        console.error('PHPFlasher Toastr: Error setting Turbo compatibility', error)
                    }
                }
            } catch (error) {
                console.error('PHPFlasher Toastr: Error rendering notification', error, envelope)
            }
        })
    }

    /**
     * Apply global options to Toastr.
     *
     * This method configures the Toastr library with the provided options,
     * which will affect all subsequently created notifications.
     *
     * @param options - Configuration options for Toastr
     */
    public renderOptions(options: Options): void {
        // Check for dependencies
        if (!this.isDependencyAvailable()) {
            return
        }

        try {
            // Apply default options and merge with provided options
            toastr.options = {
                timeOut: (options.timeOut || 10000) as number, // Default 10 seconds
                progressBar: (options.progressBar || true) as boolean, // Show progress bar by default
                ...options,
            } as ToastrOptions
        } catch (error) {
            console.error('PHPFlasher Toastr: Error applying options', error)
        }
    }

    /**
     * Check if jQuery and Toastr dependencies are available
     *
     * @returns True if dependencies are available
     * @private
     */
    private isDependencyAvailable(): boolean {
        // Check for jQuery (handle both window.jQuery and window.$ usage)
        const jQuery = window.jQuery || window.$

        if (!jQuery) {
            console.error('PHPFlasher Toastr: jQuery is required but not loaded. Make sure jQuery is loaded before using Toastr.')
            return false
        }

        return true
    }
}
