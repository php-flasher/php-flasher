import './flasher.scss'
import type { Envelope } from '../../types'
import { getA11yString, getCloseButtonA11y } from '../shared/accessibility'
import { CLASS_NAMES, getTitle } from '../shared/constants'

export const flasherTheme = {
    render: (envelope: Envelope): string => {
        const { type, title, message } = envelope

        const displayTitle = getTitle(title, type)

        return `
            <div class="${CLASS_NAMES.theme('flasher')} ${CLASS_NAMES.type(type)}" ${getA11yString(type)}>
                <div class="${CLASS_NAMES.content}">
                    <div class="${CLASS_NAMES.icon}"></div>
                    <div>
                        <strong class="${CLASS_NAMES.title}">${displayTitle}</strong>
                        <span class="${CLASS_NAMES.message}">${message}</span>
                    </div>
                    <button class="${CLASS_NAMES.close}" ${getCloseButtonA11y(type)}>&times;</button>
                </div>
                <span class="${CLASS_NAMES.progressBar}">
                    <span class="${CLASS_NAMES.progress}"></span>
                </span>
            </div>`
    },
}
