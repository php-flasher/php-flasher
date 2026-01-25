import { Controller } from '@hotwired/stimulus'
import { showNotificationsForHandler } from '../show_notifications'

import jQuery from 'jquery'
import 'toastr/build/toastr.min.css'

// Make jQuery available globally for toastr
window.jQuery = jQuery
window.$ = jQuery

export default class extends Controller {
    connect() {
        showNotificationsForHandler('toastr')
    }
}
