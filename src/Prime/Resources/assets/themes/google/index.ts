/**
 * @file PHPFlasher Google Theme Registration
 * @description Registers the Google theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { googleTheme } from './google'

/**
 * Register the Google theme.
 *
 * This theme provides notifications styled after Google's Material Design system.
 * The registration makes the theme available under the name 'google'.
 *
 * The Google theme can be used by calling:
 * ```typescript
 * flasher.use('theme.google').success('Operation completed successfully');
 * ```
 *
 * Key features:
 * - Material Design card with proper elevation
 * - Google's typography system with Roboto font
 * - Material Design icons and color palette
 * - Ripple effect on interaction
 * - UPPERCASE action button text
 * - Proper implementation of Material Design light and dark themes
 */
flasher.addTheme('google', googleTheme)
