import './slack.scss'
import type { Envelope } from '../../types'
import { getCloseIcon } from '../shared/icons'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES } from '../shared/constants'

const TYPE_ICONS: Record<string, string> = {
    success: '✓',
    error: '✕',
    warning: '!',
    info: 'i',
}

export const slackTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        const iconChar = TYPE_ICONS[type] || ''

        return `
            <div class="${CLASS_NAMES.theme('slack')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-slack-message">
                    <div class="fl-avatar">
                        <div class="fl-type-icon fl-${type}-icon">${iconChar}</div>
                    </div>
                    <div class="fl-message-content">
                        <div class="fl-message-text">${message}</div>
                    </div>
                    <div class="${CLASS_NAMES.actions}">
                        <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                            ${getCloseIcon()}
                        </button>
                    </div>
                </div>
            </div>`
    },
}
