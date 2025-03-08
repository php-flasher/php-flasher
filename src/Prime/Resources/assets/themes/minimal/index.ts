/**
 * @file PHPFlasher Minimal Theme Registration
 * @description Registers the Minimal theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { minimalTheme } from './minimal'

/**
 * Register the Minimal theme.
 *
 * This theme provides an ultra-clean, distraction-free notification style
 * that integrates smoothly into modern interfaces without drawing unnecessary attention.
 *
 * The registration makes the theme available under the name 'minimal'.
 *
 * The Minimal theme can be used by calling:
 * ```typescript
 * flasher.use('theme.minimal').success('Changes saved');
 * ```
 *
 * Key features:
 * - Translucent background with subtle blur
 * - Compact design with minimal visual elements
 * - Small colored dot instead of large icons
 * - Thin progress indicator
 * - Short, subtle entrance animation
 */
flasher.addTheme('minimal', minimalTheme)
