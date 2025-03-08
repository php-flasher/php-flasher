/**
 * @file PHPFlasher Amazon Theme Registration
 * @description Registers the Amazon theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { amazonTheme } from './amazon'

/**
 * Register the Amazon theme.
 *
 * This theme provides notifications styled after Amazon's design system.
 * The registration makes the theme available under the name 'amazon'.
 *
 * The Amazon theme can be used by calling:
 * ```typescript
 * flasher.use('theme.amazon').success('Your order has been placed');
 * ```
 *
 * Key features:
 * - Clean, minimal design inspired by Amazon's alert components
 * - Type-specific colors and icons
 * - Accessible structure with appropriate ARIA roles and attributes
 * - Support for both light and dark modes
 * - RTL language support
 */
flasher.addTheme('amazon', amazonTheme)
