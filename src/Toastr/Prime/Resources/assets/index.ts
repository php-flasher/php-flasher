/**
 * @file Toastr Plugin Entry Point
 * @description Registers the Toastr plugin with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '@flasher/flasher'
import ToastrPlugin from './toastr'

/**
 * Create and register the Toastr plugin with PHPFlasher.
 *
 * This enables using Toastr for displaying notifications through
 * the PHPFlasher API.
 *
 * @example
 * ```typescript
 * // With the plugin already registered
 * import flasher from '@flasher/flasher';
 *
 * // Basic usage
 * flasher.use('toastr').success('Operation completed');
 *
 * // With a title
 * flasher.use('toastr').error('Connection failed', 'Error');
 * ```
 */
const toastrPlugin = new ToastrPlugin()
flasher.addPlugin('toastr', toastrPlugin)

/**
 * Export the Toastr plugin instance.
 *
 * This allows direct access to the plugin if needed.
 *
 * @example
 * ```typescript
 * import toastr from '@flasher/flasher-toastr';
 *
 * toastr.success('Operation completed');
 * ```
 */
export default toastrPlugin
