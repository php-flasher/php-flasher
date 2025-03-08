/**
 * @file PHPFlasher Default Theme Registration
 * @description Registers the default theme with PHPFlasher
 * @author Younes ENNAJI
 */
import flasher from '../../index'
import { flasherTheme } from './flasher'

/**
 * Register the default "flasher" theme.
 *
 * This theme is automatically registered when PHPFlasher is initialized
 * and is used as the default theme when no specific theme is requested.
 *
 * The flasher theme is used whenever:
 * - You call flasher.success(), flasher.error(), etc. directly
 * - You use flasher.use('flasher') explicitly
 * - You use flasher.use('theme.flasher') explicitly
 */
flasher.addTheme('flasher', flasherTheme)
