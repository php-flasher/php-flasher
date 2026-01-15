import './sapphire.scss'
import type { Envelope } from '../../types'

export const sapphireTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        const isAlert = type === 'error' || type === 'warning'
        const role = isAlert ? 'alert' : 'status'
        const ariaLive = isAlert ? 'assertive' : 'polite'

        return `
            <div class="fl-sapphire fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <span class="fl-message">${message}</span>
                </div>
                <div class="fl-progress-bar">
                    <div class="fl-progress"></div>
                </div>
            </div>`
    },
}
