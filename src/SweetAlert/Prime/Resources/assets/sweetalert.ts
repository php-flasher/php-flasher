/**
 * @file SweetAlert Plugin Implementation
 * @description PHPFlasher integration with the SweetAlert2 library
 * @author Younes ENNAJI
 */
import { AbstractPlugin } from '@flasher/flasher/dist/plugin'
import type { Envelope, Options } from '@flasher/flasher/dist/types'

import type { SweetAlertOptions, SweetAlertResult } from 'sweetalert2'
import Swal from 'sweetalert2'

/** Type alias for Swal constructor */
type SwalType = typeof Swal

/**
 * Plugin implementation for SweetAlert2 notification library.
 *
 * The SweetAlertPlugin integrates SweetAlert2 with PHPFlasher, allowing
 * for beautiful, responsive modal dialogs with a wide range of customization
 * options.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 * import SweetAlertPlugin from '@flasher/flasher-sweetalert';
 *
 * // Register the plugin
 * flasher.addPlugin('sweetalert', new SweetAlertPlugin());
 *
 * // Show a notification
 * flasher.use('sweetalert').success('Operation completed');
 * ```
 */
export default class SweetAlertPlugin extends AbstractPlugin {
    /**
     * The SweetAlert instance used to display notifications.
     * Lazy-initialized when first needed.
     *
     * @private
     */
    private sweetalert?: SwalType

    /**
     * Creates SweetAlert notifications from envelopes.
     *
     * This method processes each envelope sequentially, ensuring
     * modals are displayed one after another rather than simultaneously.
     *
     * @param envelopes - Array of notification envelopes to render
     * @returns Promise that resolves when all notifications have been displayed
     */
    public async renderEnvelopes(envelopes: Envelope[]): Promise<void> {
        if (!this.sweetalert) {
            this.initializeSweetAlert()
        }

        try {
            // Process envelopes sequentially to avoid multiple modals at once
            for (const envelope of envelopes) {
                await this.renderEnvelope(envelope)
            }
        } catch (error) {
            console.error('PHPFlasher SweetAlert: Error rendering envelopes', error)
        }
    }

    /**
     * Apply global options to SweetAlert.
     *
     * This method configures SweetAlert with default options that will
     * be applied to all subsequent modal dialogs.
     *
     * @param options - Configuration options for SweetAlert
     */
    public renderOptions(options: Options): void {
        try {
            // Create a SweetAlert mixin with default options
            this.sweetalert = this.sweetalert || Swal.mixin({
                timer: (options.timer || 10000) as unknown, // Default 10 seconds
                timerProgressBar: (options.timerProgressBar || true) as unknown,
                ...options,
            } as SweetAlertOptions)

            // Handle Turbo/Hotwire page transitions
            this.setupTurboCompatibility()
        } catch (error) {
            console.error('PHPFlasher SweetAlert: Error applying options', error)
        }
    }

    /**
     * Render a single notification envelope as a SweetAlert modal.
     *
     * This method transforms a PHPFlasher envelope into a SweetAlert modal
     * and dispatches a custom event with the result for potential listeners.
     *
     * @param envelope - The notification envelope to render
     * @returns Promise that resolves when the modal is closed
     * @private
     */
    private async renderEnvelope(envelope: Envelope): Promise<void> {
        try {
            // Extract and merge options
            let { options } = envelope

            // Set up the SweetAlert options
            options = {
                ...options,
                icon: (options?.icon || envelope.type) as unknown,
                text: (options?.text || envelope.message) as unknown,
            }

            // Show the modal and get the result
            const promise = await this.sweetalert?.fire(options as SweetAlertOptions)

            // Dispatch a custom event with the result and envelope
            this.dispatchResultEvent(promise, envelope)
        } catch (error) {
            console.error('PHPFlasher SweetAlert: Error rendering envelope', error, envelope)
        }
    }

    /**
     * Initialize SweetAlert with default options if not already created.
     *
     * @private
     */
    private initializeSweetAlert(): void {
        if (!this.sweetalert) {
            this.renderOptions({
                timer: 10000, // 10 seconds
                timerProgressBar: true,
            })
        }
    }

    /**
     * Set up event listeners for compatibility with Turbo/Hotwire page transitions.
     * Ensures modals are properly closed when navigating between pages.
     *
     * @private
     */
    private setupTurboCompatibility(): void {
        // Close any open modals before Turbo caches the page
        document.addEventListener('turbo:before-cache', () => {
            if (Swal.isVisible()) {
                // Remove animations to prevent visual glitches during page transitions
                const popup = Swal.getPopup()
                if (popup) {
                    popup.style.setProperty('animation-duration', '0ms')
                }

                // Close the modal immediately
                Swal.close()
            }
        })
    }

    /**
     * Dispatch a custom event with the SweetAlert result and envelope.
     * This allows external code to react to modal interactions.
     *
     * @param promise - The result from SweetAlert
     * @param envelope - The original notification envelope
     * @private
     */
    private dispatchResultEvent(
        promise: SweetAlertResult<any> | undefined,
        envelope: Envelope,
    ): void {
        if (promise) {
            window.dispatchEvent(new CustomEvent('flasher:sweetalert:promise', {
                detail: {
                    promise,
                    envelope,
                },
            }))
        }
    }
}
