import './material.scss'
import type { Envelope } from '../../types'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES, DEFAULT_TEXT } from '../shared/constants'

export const materialTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        return `
            <div class="${CLASS_NAMES.theme('material')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-md-card">
                    <div class="${CLASS_NAMES.content}">
                        <div class="fl-text-content">
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
