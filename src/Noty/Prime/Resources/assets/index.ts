/**
 * @file Noty Plugin Entry Point
 * @description Registers the Noty plugin with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '@flasher/flasher'
import NotyPlugin from './noty'

/**
 * Create and register the Noty plugin with PHPFlasher.
 *
 * This enables using Noty for displaying notifications through
 * the PHPFlasher API.
 *
 * @example
 * ```typescript
 * // With the plugin already registered
 * import flasher from '@flasher/flasher';
 *
 * flasher.use('noty').success('Operation completed');
 * ```
 */
const noty = new NotyPlugin()
flasher.addPlugin('noty', noty)

/**
 * Export the Noty plugin instance.
 *
 * This allows direct access to the plugin if needed.
 *
 * @example
 * ```typescript
 * import noty from '@flasher/flasher-noty';
 *
 * noty.success('Operation completed');
 * ```
 */
export default noty
