import { Controller } from '@hotwired/stimulus'

import './tryit.pcss'

import flasher from '@flasher/flasher'
import '@flasher/flasher-toastr'
import '@flasher/flasher-noty'
import '@flasher/flasher-notyf'
import '@flasher/flasher-sweetalert'

import '@flasher/flasher/dist/themes/amazon/amazon'
import '@flasher/flasher/dist/themes/amber/amber'
import '@flasher/flasher/dist/themes/aurora/aurora'
import '@flasher/flasher/dist/themes/crystal/crystal'
import '@flasher/flasher/dist/themes/emerald/emerald'
import '@flasher/flasher/dist/themes/facebook/facebook'
import '@flasher/flasher/dist/themes/google/google'
import '@flasher/flasher/dist/themes/ios/ios'
import '@flasher/flasher/dist/themes/jade/jade'
import '@flasher/flasher/dist/themes/material/material'
import '@flasher/flasher/dist/themes/minimal/minimal'
import '@flasher/flasher/dist/themes/neon/neon'
import '@flasher/flasher/dist/themes/onyx/onyx'
import '@flasher/flasher/dist/themes/ruby/ruby'
import '@flasher/flasher/dist/themes/sapphire/sapphire'
import '@flasher/flasher/dist/themes/slack/slack'

export default class extends Controller {
    initialize() {
        window.flasher = flasher
    }
}
