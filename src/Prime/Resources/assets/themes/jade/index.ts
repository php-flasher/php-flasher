/**
 * @file PHPFlasher Jade Theme Registration
 * @description Registers the Jade theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { jadeTheme } from './jade'

/**
 * Register the Jade theme.
 *
 * This theme provides a calm, minimalist notification style with
 * soft colors and refined animations.
 *
 * The registration makes the theme available under the name 'jade'.
 *
 * The Jade theme can be used by calling:
 * ```typescript
 * flasher.use('theme.jade').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Clean, minimalist design with no icons
 * - Soft color palette with pastel tones
 * - Generous rounded corners for a friendly appearance
 * - Subtle entrance animation with scale and fade effects
 * - Type-specific background and text colors
 */
flasher.addTheme('jade', jadeTheme)
