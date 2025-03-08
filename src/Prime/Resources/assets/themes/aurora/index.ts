/**
 * @file PHPFlasher Aurora Theme Registration
 * @description Registers the Aurora theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { auroraTheme } from './aurora'

/**
 * Register the Aurora theme.
 *
 * This theme provides an elegant glass-morphism notification style with
 * subtle gradients and backdrop blur effects.
 *
 * The registration makes the theme available under the name 'aurora'.
 *
 * The Aurora theme can be used by calling:
 * ```typescript
 * flasher.use('theme.aurora').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Glass-like appearance with blur effects
 * - Type-specific gradient backgrounds
 * - Minimalist design without icons
 * - Smooth entrance animation
 * - Progress indicator
 */
flasher.addTheme('aurora', auroraTheme)
