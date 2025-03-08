/**
 * @file PHPFlasher Main Entry Point
 * @description Creates and exports the default PHPFlasher instance
 * @author Younes ENNAJI
 */
import Flasher from './flasher'
import { flasherTheme } from './themes'

/**
 * Create and configure the default Flasher instance.
 *
 * This singleton instance is the main entry point for the PHPFlasher library.
 * It comes pre-configured with the default theme.
 */
const flasher = new Flasher()
flasher.addTheme('flasher', flasherTheme)

/**
 * Make the flasher instance available globally for browser scripts.
 *
 * This allows PHPFlasher to be used in vanilla JavaScript without
 * module imports.
 *
 * @example
 * ```javascript
 * // In a browser script
 * window.flasher.success('Operation completed');
 * ```
 */
if (typeof window !== 'undefined') {
    window.flasher = flasher
}

/**
 * Default export of the pre-configured flasher instance.
 *
 * @example
 * ```typescript
 * import flasher from '@flasher/flasher';
 *
 * flasher.success('Operation completed');
 * ```
 */
export default flasher
