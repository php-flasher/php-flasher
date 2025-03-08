/**
 * @file SweetAlert Plugin Entry Point
 * @description Registers the SweetAlert plugin with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '@flasher/flasher'
import SweetAlertPlugin from './sweetalert'

/**
 * Create and register the SweetAlert plugin with PHPFlasher.
 *
 * This enables using SweetAlert for displaying notifications through
 * the PHPFlasher API.
 *
 * @example
 * ```typescript
 * // With the plugin already registered
 * import flasher from '@flasher/flasher';
 *
 * // Basic success message
 * flasher.use('sweetalert').success('Operation completed');
 *
 * // Confirmation dialog
 * flasher.use('sweetalert').warning('Are you sure?', 'Confirmation', {
 *   showCancelButton: true,
 *   confirmButtonText: 'Yes, delete it!',
 *   cancelButtonText: 'Cancel'
 * });
 *
 * // Listen for user interaction results
 * window.addEventListener('flasher:sweetalert:promise', (event) => {
 *   const { promise, envelope } = event.detail;
 *   if (promise.isConfirmed) {
 *     // User clicked confirm button
 *     console.log('User confirmed', envelope);
 *   }
 * });
 * ```
 */
const sweetalert = new SweetAlertPlugin()
flasher.addPlugin('sweetalert', sweetalert)

/**
 * Export the SweetAlert plugin instance.
 *
 * This allows direct access to the plugin if needed.
 *
 * @example
 * ```typescript
 * import sweetalert from '@flasher/flasher-sweetalert';
 *
 * sweetalert.success('Operation completed');
 * ```
 */
export default sweetalert
