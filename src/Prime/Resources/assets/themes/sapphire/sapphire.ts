import './sapphire.scss'
import type { Envelope } from '../../types'
import { getA11yString } from '../shared/accessibility'
import { CLASS_NAMES } from '../shared/constants'

export const sapphireTheme = {
    render: (envelope: Envelope): string => {
        const { type, message } = envelope

        return `
            <div class="${CLASS_NAMES.theme('sapphire')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="${CLASS_NAMES.content}">
                    <span class="${CLASS_NAMES.message}">${message}</span>
                </div>
                <div class="${CLASS_NAMES.progressBar}">
                    <div class="${CLASS_NAMES.progress}"></div>
                </div>
            </div>`
    },
}
