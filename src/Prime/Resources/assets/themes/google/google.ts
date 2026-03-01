import './google.scss'
import type { Envelope } from '../../types'
import { getTypeIcon } from '../shared/icons'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES, DEFAULT_TEXT } from '../shared/constants'

export const googleTheme = {
    render: (envelope: Envelope): string => {
        const { type, message, title } = envelope

        const titleSection = title ? `<div class="${CLASS_NAMES.title}">${title}</div>` : ''

        return `
            <div class="${CLASS_NAMES.theme('google')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-md-card">
                    <div class="${CLASS_NAMES.content}">
                        <div class="${CLASS_NAMES.iconWrapper}">
                            ${getTypeIcon(type, { size: 'lg', className: 'fl-icon-svg' })}
                        </div>
                        <div class="fl-text-content">
                            ${titleSection}
                            <div class="${CLASS_NAMES.message}">${message}</div>
                        </div>
                    </div>
                    <div class="${CLASS_NAMES.actions}">
                        <button class="fl-action-button ${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>
                            ${DEFAULT_TEXT.dismissButton}
                        </button>
                    </div>
                </div>
                <div class="${CLASS_NAMES.progressBar}">
                    <div class="${CLASS_NAMES.progress}"></div>
                </div>
            </div>`
    },
}
