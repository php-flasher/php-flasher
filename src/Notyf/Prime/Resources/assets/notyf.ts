/**
 * @file Notyf Plugin Implementation
 * @description PHPFlasher integration with the Notyf notification library
 * @author Younes ENNAJI
 */
import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import { Notyf } from 'notyf'
import type { INotyfOptions } from 'notyf/notyf.options'
import 'notyf/notyf.min.css'

/**
 * Plugin implementation for Notyf notification library.
 *
 * The NotyfPlugin integrates the lightweight Notyf library with PHPFlasher,
 * allowing for simple, responsive, and customizable toast notifications.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import NotyfPlugin from '@flasher/flasher-notyf';
 *
 * // Register the plugin
 * flasher.addPlugin('notyf', new NotyfPlugin());
 *
 * // Show a notification
 * flasher.use('notyf').success('Operation completed');
 * ```
 */
export default class NotyfPlugin extends AbstractPlugin {
    /**
     * The Notyf instance used to display notifications.
     * Lazy-initialized when first needed.
     *
     * @private
     */
    private notyf?: Notyf

    /**
     * Creates Notyf notifications from envelopes.
     *
     * This method transforms PHPFlasher envelopes into Notyf notifications
     * and displays them using the Notyf library.
     *
     * @param envelopes - Array of notification envelopes to render
     */
    public renderEnvelopes(envelopes: Envelope[]): void {
        if (!this.notyf) {
            this.initializeNotyf()
        }

        envelopes.forEach((envelope) => {
            try {
                // Merge envelope properties with its options for Notyf compatibility
                const options = { ...envelope, ...envelope.options }
                this.notyf?.open(options)
            } catch (error) {
                console.error('PHPFlasher Notyf: Error rendering notification', error, envelope)
            }
        })

        // Ensure compatibility with Turbo/Hotwire by marking containers
        // as temporary elements that should be preserved during page transitions
        try {
            if (this.notyf) {
                // @ts-expect-error - Accessing internal Notyf properties
                const container = this.notyf.view.container
                // @ts-expect-error - Accessing internal Notyf properties
                const a11yContainer = this.notyf.view.a11yContainer

                if (container && container.dataset) {
                    container.dataset.turboTemporary = ''
                }

                if (a11yContainer && a11yContainer.dataset) {
                    a11yContainer.dataset.turboTemporary = ''
                }
            }
        } catch (error) {
            console.error('PHPFlasher Notyf: Error setting Turbo compatibility', error)
        }
    }

    /**
     * Apply global options to Notyf.
     *
     * This method configures the Notyf library with the provided options,
     * which will affect all subsequently created notifications. It also
     * adds support for additional notification types beyond the default
     * success and error types.
     *
     * @param options - Configuration options for Notyf
     */
    public renderOptions(options: Options): void {
        if (!options) {
            return
        }

        const notyfOptions = {
            duration: options.duration || 10000, // Default timeout of 10 seconds
            ...options,
        } as unknown as INotyfOptions

        // Initialize types array if not present
        notyfOptions.types = notyfOptions.types || []

        // Add support for info notifications with custom icon
        this.addTypeIfNotExists(notyfOptions.types, {
            type: 'info',
            className: 'notyf__toast--info',
            background: '#5784E5', // Blue color
            icon: {
                className: 'notyf__icon--info',
                tagName: 'i',
            },
        })

        // Add support for warning notifications with custom icon
        this.addTypeIfNotExists(notyfOptions.types, {
            type: 'warning',
            className: 'notyf__toast--warning',
            background: '#E3A008', // Amber color
            icon: {
                className: 'notyf__icon--warning',
                tagName: 'i',
            },
        })

        // Create or update Notyf instance with new options
        this.notyf = this.notyf || new Notyf(notyfOptions)
    }

    /**
     * Initialize the Notyf instance with default options if not already created.
     *
     * @private
     */
    private initializeNotyf(): void {
        if (!this.notyf) {
            // Default configuration with info and warning types
            this.renderOptions({
                duration: 10000, // 10 seconds
                position: { x: 'right', y: 'top' },
                dismissible: true,
            })
        }
    }

    /**
     * Add a notification type to Notyf if it doesn't already exist.
     * Prevents duplicate type definitions.
     *
     * @param types - Array of notification types
     * @param newType - New type to add
     * @private
     */
    private addTypeIfNotExists(types: any[], newType: any): void {
        // Check if type already exists
        const exists = types.some((type) => type.type === newType.type)
        if (!exists) {
            types.push(newType)
        }
    }
}
