import './amazon.scss'
import type { Envelope } from '../../types'
import { getTypeIcon, getCloseIcon } from '../shared/icons'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES, DEFAULT_TITLES } from '../shared/constants'

const AMAZON_TITLES: Record<string, string> = {
    success: 'Success!',
    error: 'Problem',
    warning: 'Warning',
    info: 'Information',
}

export const amazonTheme = {
    render: (envelope: Envelope): string => {
        const { type, message, title } = envelope

        const alertTitle = title || AMAZON_TITLES[type] || DEFAULT_TITLES[type] || 'Alert'

        return `
            <div class="${CLASS_NAMES.theme('amazon')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-amazon-alert">
                    <div class="fl-alert-content">
                        <div class="fl-icon-container">
                            ${getTypeIcon(type, { size: 'lg' })}
                        </div>
                        <div class="fl-text-content">
                            <div class="fl-alert-title">${alertTitle}</div>
                            <div class="fl-alert-message">${message}</div>
                        </div>
                    </div>
                    <div class="fl-alert-actions">
                        <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                            ${getCloseIcon()}
                        </button>
                    </div>
                </div>
            </div>`
    },
}
