import { Controller } from '@hotwired/stimulus'
import { showNotificationsForHandler } from '../show_notifications'

import '@flasher/flasher-notyf/dist/flasher-notyf.min.css'

export default class extends Controller {
    connect() {
        showNotificationsForHandler('notyf')
    }
}
