/**
 * @file PHPFlasher Ruby Theme Registration
 * @description Registers the Ruby theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { rubyTheme } from './ruby'

/**
 * Register the Ruby theme.
 *
 * This theme provides vibrant notifications with gradient backgrounds,
 * gemstone-like shine effects, and elegant animations.
 *
 * The registration makes the theme available under the name 'ruby'.
 *
 * The Ruby theme can be used by calling:
 * ```typescript
 * flasher.use('theme.ruby').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Rich gradient backgrounds for each notification type
 * - Elegant shine animation creating a gemstone-like effect
 * - Circular icon container with translucent background
 * - Smooth scale animation for entrance
 * - Improved hover effects on close button
 */
flasher.addTheme('ruby', rubyTheme)
