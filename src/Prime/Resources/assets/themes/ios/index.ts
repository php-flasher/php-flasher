/**
 * @file PHPFlasher iOS Theme Registration
 * @description Registers the iOS theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { iosTheme } from './ios'

/**
 * Register the iOS theme.
 *
 * This theme provides notifications styled after Apple's iOS notification system.
 * The registration makes the theme available under the name 'ios'.
 *
 * The iOS theme can be used by calling:
 * ```typescript
 * flasher.use('theme.ios').success('Your file was uploaded successfully');
 * ```
 *
 * Key features:
 * - Frosted glass effect with backdrop blur
 * - App icon and name in header
 * - Time display in iOS style
 * - Subtle animations mimicking iOS notification behavior
 * - iOS-style close button
 * - Full dark mode support following iOS dark appearance
 */
flasher.addTheme('ios', iosTheme)
