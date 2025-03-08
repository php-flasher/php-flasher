/**
 * @file PHPFlasher Emerald Theme Registration
 * @description Registers the Emerald theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { emeraldTheme } from './emerald'

/**
 * Register the Emerald theme.
 *
 * This theme provides an elegant glass-like notification style with bounce animation
 * and translucent background.
 *
 * The registration makes the theme available under the name 'emerald'.
 *
 * The Emerald theme can be used by calling:
 * ```typescript
 * flasher.use('theme.emerald').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Glass morphism design with backdrop blur
 * - Bounce animation on entrance
 * - Colored text based on notification type
 * - No icons or progress bar for a clean look
 * - Clean typography with the Inter font (falls back to system fonts)
 */
flasher.addTheme('emerald', emeraldTheme)
