/**
 * @file PHPFlasher Neon Theme Registration
 * @description Registers the Neon theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { neonTheme } from './neon'

/**
 * Register the Neon theme.
 *
 * This theme provides elegant notifications with subtle glowing accents
 * and a sophisticated visual style.
 *
 * The registration makes the theme available under the name 'neon'.
 *
 * The Neon theme can be used by calling:
 * ```typescript
 * flasher.use('theme.neon').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Subtle glowing accents based on notification type
 * - Floating illuminated circular indicator
 * - Frosted glass background with blur effect
 * - Refined typography with Inter font
 * - Smooth entrance animation with blur transition
 */
flasher.addTheme('neon', neonTheme)
