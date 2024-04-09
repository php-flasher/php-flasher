import { Controller } from '@hotwired/stimulus'
import { showNotificationsForHandler } from '../show_notifications'

import 'sweetalert2/dist/sweetalert2.min.css'

export default class extends Controller {
    connect() {
        showNotificationsForHandler('sweetalert')
    }
}
