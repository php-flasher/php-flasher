/**
 * @file PHPFlasher Crystal Theme Registration
 * @description Registers the Crystal theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { crystalTheme } from './crystal'

/**
 * Register the Crystal theme.
 *
 * This theme provides an elegant notification style with subtle animations
 * and a clean, minimal design.
 *
 * The registration makes the theme available under the name 'crystal'.
 *
 * The Crystal theme can be used by calling:
 * ```typescript
 * flasher.use('theme.crystal').success('Your document has been saved');
 * ```
 *
 * Key features:
 * - Clean, white background with colored text
 * - Subtle pulsing shadow effect on hover
 * - Smooth entrance animation
 * - Progress indicator
 * - Minimalist design that focuses on the message
 */
flasher.addTheme('crystal', crystalTheme)
