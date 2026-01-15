import './notyf.scss'

import flasher from '@flasher/flasher'
import NotyfPlugin from './notyf'

const notyf = new NotyfPlugin()
flasher.addPlugin('notyf', notyf)

export default notyf
