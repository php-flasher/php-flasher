import './flasher.scss'

import type { Envelope } from '../../types'

export const flasherTheme = {
    render: (envelope: Envelope): string => {
        const { type, title, message } = envelope

        return `
            <div class="fl-flasher fl-${type}">
                <div class="fl-content">
                    <div class="fl-icon"></div>
                    <div>
                        <strong class="fl-title">${title}</strong>
                        <span class="fl-message">${message}</span>
                    </div>
                    <button class="fl-close">&times;</button>
                </div>
                <span class="fl-progress-bar"></span>
            </div>`
    },
}
