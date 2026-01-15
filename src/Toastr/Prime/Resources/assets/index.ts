import flasher from '@flasher/flasher'
import ToastrPlugin from './toastr'

const toastrPlugin = new ToastrPlugin()
flasher.addPlugin('toastr', toastrPlugin)

export default toastrPlugin
