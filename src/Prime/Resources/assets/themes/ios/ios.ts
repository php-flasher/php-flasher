import './ios.scss'
import type { Envelope } from '../../types'
import { getTypeIcon } from '../shared/icons'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES } from '../shared/constants'

const APP_NAME = 'PHPFlasher'

function getTimeString(): string {
    const now = new Date()
    return now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })
}

export const iosTheme = {
    render: (envelope: Envelope): string => {
        const { type, message, title } = envelope

        const displayTitle = title || APP_NAME

        return `
            <div class="${CLASS_NAMES.theme('ios')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-ios-notification">
                    <div class="fl-header">
                        <div class="fl-app-icon">
                            ${getTypeIcon(type, { size: 'md', className: 'fl-icon-svg' })}
                        </div>
                        <div class="fl-app-info">
                            <div class="fl-app-name">${displayTitle}</div>
                            <div class="fl-time">${getTimeString()}</div>
                        </div>
                    </div>
                    <div class="${CLASS_NAMES.content}">
                        <div class="${CLASS_NAMES.message}">${message}</div>
                    </div>
                    <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>`
    },
}
