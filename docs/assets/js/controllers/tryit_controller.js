import { Controller } from '@hotwired/stimulus'

import './tryit.pcss'

import flasher from '@flasher/flasher'
import '@flasher/flasher-toastr'
import '@flasher/flasher-noty'
import '@flasher/flasher-notyf'
import '@flasher/flasher-sweetalert'

window.flasher = flasher

export default class extends Controller {
    connect() {
        this.initializeCodeBlocks()
    }

    initializeCodeBlocks() {
        document.querySelectorAll('pre > code').forEach((codeBlock) => {
            if (codeBlock.textContent.trim().startsWith('#/')) {
                this.addTryItButtonToCodeBlock(codeBlock)
            }
        })
    }

    addTryItButtonToCodeBlock(codeBlock) {
        const button = document.createElement('button')
        button.className = 'tryit text-indigo-500'
        button.type = 'button'
        button.ariaLabel = button.title = 'Try it!'
        button.innerHTML = '<i class="fa-duotone fa-play"></i>'
        codeBlock.parentElement.classList.add('tryable')
        codeBlock.parentElement.append(button)

        button.addEventListener('click', () => this.handleTryItButtonClick(button, codeBlock.textContent.trim()))
    }

    handleTryItButtonClick(button, code) {
        button.innerHTML = '<i class="fa-duotone fa-spinner-third spin"></i>'
        const themes = this.defineThemes()
        const example = code.split('\n')[0].trim()

        try {
            if (example === '#/ flasher darkMode') {
                this.toggleDarkMode(example)
            } else if (example in themes) {
                this.applyTheme(example, themes)
            } else if (Array.isArray(window.messages[example])) {
                window.messages[example].forEach(this.flash.bind(this))
            } else {
                this.flash(window.messages[example])
            }
        } catch (error) {
            console.error(error)
        } finally {
            setTimeout(() => (button.innerHTML = '<i class="fa-duotone fa-play"></i>'), 500)
        }
    }

    toggleDarkMode(example) {
        document.documentElement.classList.add('dark')
        this.flash(window.messages[example])
        setTimeout(() => document.documentElement.classList.remove('dark'), 5000)
    }

    applyTheme(example, themes) {
        import(`noty/lib/themes/${themes[example]}`).then(() => {
            window.messages[example].forEach(this.flash.bind(this))
        })
    }

    defineThemes() {
        return {
            '#/ noty theme sunset': 'sunset.css',
            '#/ noty theme relax': 'relax.css',
            '#/ noty theme light': 'light.css',
            '#/ noty theme metroui': 'metroui.css',
        }
    }

    flash({ handler, type, message, title, options }) {
        const factory = flasher.use(handler)
        if (factory) {
            factory.flash(type, message, title, options)
        }
    }
}
