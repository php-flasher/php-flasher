import './flasher.scss'

import type { Envelope } from '../../types'

export const flasherTheme = {
    render: (envelope: Envelope): string => {
        const { type, title, message } = envelope
        const isAlert = type === 'error' || type === 'warning'
        const role = isAlert ? 'alert' : 'status'
        const ariaLive = isAlert ? 'assertive' : 'polite'

        return `
            <div class="fl-flasher fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${title}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close" aria-label="Close ${type} message">&times;</button>
                </div>
                <span class="fl-progress-bar"></span>
            </div>`
    },
}
