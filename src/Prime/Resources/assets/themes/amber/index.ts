/**
 * @file PHPFlasher Amber Theme Registration
 * @description Registers the Amber theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { amberTheme } from './amber'

/**
 * Register the Amber theme.
 *
 * This theme provides a modern, clean notification style with elegant aesthetics.
 * The registration makes the theme available under the name 'amber'.
 *
 * The Amber theme can be used by calling:
 * ```typescript
 * flasher.use('theme.amber').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Modern, minimalist design
 * - Clean typography with optimal readability
 * - Subtle entrance animation
 * - Progress indicator
 * - Full dark mode support
 * - RTL language support
 */
flasher.addTheme('amber', amberTheme)
