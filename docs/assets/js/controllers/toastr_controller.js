import { Controller } from '@hotwired/stimulus'
import { showNotificationsForHandler } from '../show_notifications'

import 'toastr/build/toastr.min.css'

export default class extends Controller {
    connect() {
        showNotificationsForHandler('toastr')
    }
}
