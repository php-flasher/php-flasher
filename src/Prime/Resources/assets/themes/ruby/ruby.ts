import './ruby.scss'
import type { Envelope } from '../../types'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES } from '../shared/constants'

export const rubyTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        return `
            <div class="${CLASS_NAMES.theme('ruby')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="fl-shine"></div>
                <div class="${CLASS_NAMES.content}">
                    <div class="fl-icon-circle">
                        <div class="${CLASS_NAMES.icon}"></div>
                    </div>
                    <div class="${CLASS_NAMES.text}">
                        <div class="${CLASS_NAMES.message}">${message}</div>
                    </div>
                    <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>×</button>
                </div>
                <div class="${CLASS_NAMES.progressBar}">
                    <div class="${CLASS_NAMES.progress}"></div>
                </div>
            </div>`
    },
}
