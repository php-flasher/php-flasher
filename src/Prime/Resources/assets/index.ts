import Flasher from './flasher'
import { flasherTheme } from './themes/flasher'

const flasher = new Flasher()
flasher.addTheme('flasher', flasherTheme)

export default flasher
