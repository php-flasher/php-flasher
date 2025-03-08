/**
 * @file PHPFlasher Theme Exports
 * @description Exports all available notification themes
 * @author Younes ENNAJI
 */

/**
 * Export all available themes for PHPFlasher.
 *
 * These themes provide different visual styles for notifications and can be
 * used by specifying the theme name when showing a notification:
 *
 * @example
 * ```typescript
 * // Use a specific theme
 * flasher.use('theme.material').success('Operation completed');
 *
 * // Set a theme as default
 * flasher.addPlugin('flasher', flasher.use('theme.slack'));
 * ```
 */
export { amazonTheme } from './amazon/amazon'
export { amberTheme } from './amber/amber'
export { auroraTheme } from './aurora/aurora'
export { crystalTheme } from './crystal/crystal'
export { emeraldTheme } from './emerald/emerald'
export { facebookTheme } from './facebook/facebook'
export { flasherTheme } from './flasher/flasher'
export { googleTheme } from './google/google'
export { iosTheme } from './ios/ios'
export { jadeTheme } from './jade/jade'
export { materialTheme } from './material/material'
export { minimalTheme } from './minimal/minimal'
export { neonTheme } from './neon/neon'
export { onyxTheme } from './onyx/onyx'
export { rubyTheme } from './ruby/ruby'
export { sapphireTheme } from './sapphire/sapphire'
export { slackTheme } from './slack/slack'
