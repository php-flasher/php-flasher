import { Controller } from '@hotwired/stimulus'
import { showNotificationsForHandler } from '../show_notifications'

import 'noty/lib/noty.css'
import 'noty/lib/themes/mint.css'

export default class extends Controller {
    connect() {
        showNotificationsForHandler('noty')
    }
}
