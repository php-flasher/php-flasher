import { Controller } from '@hotwired/stimulus'

import { ray } from 'node-ray/web'

export default class extends Controller {
    initialize() {
        window.ray = ray
    }
}
