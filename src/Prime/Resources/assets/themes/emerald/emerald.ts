import './emerald.scss'
import type { Envelope } from '../../types'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES } from '../shared/constants'

export const emeraldTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        return `
            <div class="${CLASS_NAMES.theme('emerald')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="${CLASS_NAMES.content}">
                    <div class="${CLASS_NAMES.message}">${message}</div>
                    <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>×</button>
                </div>
            </div>`
    },
}
