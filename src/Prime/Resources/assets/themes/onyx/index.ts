/**
 * @file PHPFlasher Onyx Theme Registration
 * @description Registers the Onyx theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { onyxTheme } from './onyx'

/**
 * Register the Onyx theme.
 *
 * This theme provides modern, floating notifications with subtle accent dots
 * and a clean, sophisticated design.
 *
 * The registration makes the theme available under the name 'onyx'.
 *
 * The Onyx theme can be used by calling:
 * ```typescript
 * flasher.use('theme.onyx').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Clean, floating cards with elegant shadows
 * - Colored accent dots in the corners
 * - Generous rounded corners (1rem radius)
 * - Smooth entrance animation with blur transition
 * - Minimal design without icons
 * - Type-specific colored accents and progress bar
 */
flasher.addTheme('onyx', onyxTheme)
