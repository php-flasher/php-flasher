import { Controller } from '@hotwired/stimulus'

import './clipboard.pcss'

export default class extends Controller {
    connect() {
        const codeBlocks = document.querySelectorAll('pre > code')

        codeBlocks.forEach((codeBlock) => {
            const button = document.createElement('button')
            button.classList.add('copy', 'text-indigo-500')
            button.type = 'button'
            button.ariaLabel = button.title = 'Copy code to clipboard'

            const icon = '<i class="fa-duotone fa-clipboard"></i>'
            button.innerHTML = icon

            const parent = codeBlock.parentElement
            parent.classList.add('copyable')

            parent.append(button)

            button.addEventListener('click', () => {
                let code = codeBlock.textContent.trim()
                if (code.startsWith('#')) {
                    const parts = code.split('\n')
                    parts.shift()
                    code = parts.join('\n')
                }

                window.navigator.clipboard.writeText(code)

                button.innerHTML = '<i class="fa-duotone fa-clipboard-check"></i>'

                setTimeout(() => {
                    button.innerHTML = icon
                }, 1000)
            })
        })
    }
}
