/**
 * @file PHPFlasher Sapphire Theme Registration
 * @description Registers the Sapphire theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { sapphireTheme } from './sapphire'

/**
 * Register the Sapphire theme.
 *
 * This theme provides modern, glassmorphic notifications with blurred
 * backdrop effect and a clean, minimal design.
 *
 * The registration makes the theme available under the name 'sapphire'.
 *
 * The Sapphire theme can be used by calling:
 * ```typescript
 * flasher.use('theme.sapphire').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Glassmorphic design with backdrop blur effect
 * - Minimal interface without icons or close buttons
 * - Type-specific colored backgrounds with high transparency
 * - Subtle entrance animation with a slight bounce
 * - Clean progress indicator at the bottom
 */
flasher.addTheme('sapphire', sapphireTheme)
