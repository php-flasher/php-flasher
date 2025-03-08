/**
 * @file PHPFlasher Material Design Theme Registration
 * @description Registers the Material Design theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { materialTheme } from './material'

/**
 * Register the Material Design theme.
 *
 * This theme provides minimalist notifications styled after Google's Material Design system.
 * The registration makes the theme available under the name 'material'.
 *
 * The Material theme can be used by calling:
 * ```typescript
 * flasher.use('theme.material').success('Operation completed successfully');
 * ```
 *
 * Key features:
 * - Clean Material Design card with proper elevation
 * - Material typography system with Roboto font
 * - UPPERCASE action button text following Material guidelines
 * - Ripple effect on button interaction
 * - Linear progress indicator
 * - Minimalist design without icons
 */
flasher.addTheme('material', materialTheme)
