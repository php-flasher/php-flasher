/**
 * @file PHPFlasher Facebook Theme Registration
 * @description Registers the Facebook theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { facebookTheme } from './facebook'

/**
 * Register the Facebook theme.
 *
 * This theme provides notifications styled after Facebook's interface design.
 * The registration makes the theme available under the name 'facebook'.
 *
 * The Facebook theme can be used by calling:
 * ```typescript
 * flasher.use('theme.facebook').success('Your post was published successfully');
 * ```
 *
 * Key features:
 * - Facebook-like notification cards with rounded corners and subtle shadows
 * - Type-specific circular icons with branded colors
 * - Timestamp display similar to Facebook's time format
 * - Interactive elements with hover states
 * - Facebook's distinctive font family and color palette
 */
flasher.addTheme('facebook', facebookTheme)
