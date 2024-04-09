import flasher from '@flasher/flasher'
import SweetAlertPlugin from './sweetalert'

const sweetalert = new SweetAlertPlugin()
flasher.addPlugin('sweetalert', sweetalert)

export default sweetalert
