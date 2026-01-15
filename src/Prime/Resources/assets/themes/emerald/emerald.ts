import './emerald.scss'
import type { Envelope } from '../../types'

export const emeraldTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        const isAlert = type === 'error' || type === 'warning'
        const role = isAlert ? 'alert' : 'status'
        const ariaLive = isAlert ? 'assertive' : 'polite'

        return `
            <div class="fl-emerald fl-${type}" role="${role}" aria-live="${ariaLive}" aria-atomic="true">
                <div class="fl-content">
                    <div class="fl-message">${message}</div>
                    <button class="fl-close" aria-label="Close ${type} message">×</button>
                </div>
            </div>`
    },
}
