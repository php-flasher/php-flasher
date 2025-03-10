import { Controller } from '@hotwired/stimulus'
import { showNotificationsForHandler } from '../show_notifications'

import '@flasher/flasher/dist/themes/material/material.min.css'

export default class extends Controller {
    connect() {
        showNotificationsForHandler('theme.material')
    }
}
