import flasher from '@flasher/flasher'
import NotyPlugin from './noty'

const noty = new NotyPlugin()
flasher.addPlugin('noty', noty)

export default noty
