/**
 * @file Noty Plugin Implementation
 * @description PHPFlasher integration with the Noty notification library
 * @author Younes ENNAJI
 */
import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import Noty from 'noty'
import type { Type } from 'noty'

/**
 * Plugin implementation for Noty notification library.
 *
 * The NotyPlugin integrates the Noty library with PHPFlasher, allowing
 * PHPFlasher to display notifications using Noty's rendering system.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import NotyPlugin from '@flasher/flasher-noty';
 *
 * // Register the plugin
 * flasher.addPlugin('noty', new NotyPlugin());
 *
 * // Show a notification
 * flasher.use('noty').success('Operation completed');
 * ```
 */
export default class NotyPlugin extends AbstractPlugin {
    /**
     * Default options for Noty notifications.
     *
     * These options are applied to all notifications unless overridden.
     *
     * @private
     */
    private defaultOptions: {
        timeout: number
        [key: string]: any
    } = {
            timeout: 10000,
        }

    /**
     * Creates Noty notifications from envelopes.
     *
     * This method transforms PHPFlasher envelopes into Noty notifications
     * and displays them using the Noty library.
     *
     * @param envelopes - Array of notification envelopes to render
     */
    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!envelopes?.length) {
            return
        }

        envelopes.forEach((envelope) => {
            try {
                // Create base options
                const options: any = {
                    text: envelope.message,
                    type: envelope.type as Type,
                    ...this.defaultOptions,
                }

                // Merge with envelope options
                if (envelope.options) {
                    Object.assign(options, envelope.options)
                }

                // Create and show the notification
                const noty = new Noty(options)
                noty.show()

                // Handle Turbo/Hotwire compatibility
                const layoutDom = (noty as any).layoutDom
                if (layoutDom && typeof layoutDom.dataset === 'object') {
                    layoutDom.dataset.turboTemporary = ''
                }
            } catch (error) {
                console.error('PHPFlasher Noty: Error rendering notification', error, envelope)
            }
        })
    }

    /**
     * Apply global options to Noty.
     *
     * This method configures the Noty library with the provided options,
     * which will affect all subsequently created notifications.
     *
     * @param options - Configuration options for Noty
     */
    public renderOptions(options: Options): void {
        if (!options) {
            return
        }

        // Update default options
        Object.assign(this.defaultOptions, options)

        // Apply to Noty defaults - use type assertion for compatibility
        Noty.overrideDefaults(this.defaultOptions)
    }
}
