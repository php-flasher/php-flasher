import flasher from '@flasher/flasher'
import ToastrPlugin from './toastr'

const toastr = new ToastrPlugin()
flasher.addPlugin('toastr', toastr)

export default toastr
