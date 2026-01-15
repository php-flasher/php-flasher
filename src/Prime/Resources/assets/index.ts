import Flasher from './flasher'
import { flasherTheme } from './themes'

const flasher = new Flasher()
flasher.addTheme('flasher', flasherTheme)

if (typeof window !== 'undefined') {
    window.flasher = flasher
}

export default flasher
