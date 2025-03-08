/**
 * @file PHPFlasher Slack Theme Registration
 * @description Registers the Slack theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { slackTheme } from './slack'

/**
 * Register the Slack theme.
 *
 * This theme provides notifications styled after Slack's familiar messaging interface.
 * The registration makes the theme available under the name 'slack'.
 *
 * The Slack theme can be used by calling:
 * ```typescript
 * flasher.use('theme.slack').success('Your changes have been saved');
 * ```
 *
 * Key features:
 * - Message bubbles with subtle borders and shadows
 * - Colored avatar icons indicating notification type
 * - Clean typography matching Slack's text style
 * - Hover effects that reveal action buttons
 * - Dark mode support matching Slack's dark theme
 * - RTL language support
 */
flasher.addTheme('slack', slackTheme)
