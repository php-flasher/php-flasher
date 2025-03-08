/**
 * @file Notyf Plugin Entry Point
 * @description Registers the Notyf plugin with PHPFlasher
 * @author Younes ENNAJI
 */
import './notyf.scss'

import flasher from '@flasher/flasher'
import NotyfPlugin from './notyf'

/**
 * Create and register the Notyf plugin with PHPFlasher.
 *
 * This enables using Notyf for displaying notifications through
 * the PHPFlasher API.
 *
 * @example
 * ```typescript
 * // With the plugin already registered
 * import flasher from '@flasher/flasher';
 *
 * flasher.use('notyf').success('Operation completed');
 *
 * // With custom options
 * flasher.use('notyf').info('This notification has custom options', null, {
 *   duration: 3000,
 *   ripple: true,
 *   dismissible: true
 * });
 * ```
 */
const notyf = new NotyfPlugin()
flasher.addPlugin('notyf', notyf)

/**
 * Export the Notyf plugin instance.
 *
 * This allows direct access to the plugin if needed.
 *
 * @example
 * ```typescript
 * import notyf from '@flasher/flasher-notyf';
 *
 * notyf.success('Operation completed');
 * ```
 */
export default notyf
