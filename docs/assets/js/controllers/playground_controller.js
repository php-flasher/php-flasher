import { Controller } from '@hotwired/stimulus'
import Prism from 'prismjs'
import flasher from '@flasher/flasher'

import 'prismjs/components/prism-markup-templating'
import 'prismjs/components/prism-php'

import './playground.pcss'

export default class extends Controller {
    static values = {
        adapter: String,
        type: String,
        message: String,
        title: String,
    }

    static targets = ['optionsContainer', 'codeSnippet', 'message', 'title', 'adapter', 'type']

    connect() {
        this.initializeActiveButtons()
        this.updateAdapterOptions()
        this.updateCodeSnippet()

        Prism.highlightAll()
    }

    initializeActiveButtons() {
        this.updateButtonStyles('#adapter-options', this.adapterValue)
        this.updateButtonStyles('#type-options', this.typeValue)
    }

    selectType(event) {
        const type = event.currentTarget.dataset.value
        this.typeTarget.value = type
        this.typeValue = type
        this.updateButtonStyles('#type-options', type)
    }

    updateButtonStyles(containerSelector, activeValue) {
        document.querySelectorAll(`${containerSelector} button`).forEach((button) => {
            const isActive = button.dataset.value === activeValue

            button.classList.toggle('ring-2', isActive)
            button.classList.toggle('ring-offset-2', isActive)
        })
    }

    updateAdapterOptions() {
        const options = this.fetchAdapterOptions(this.adapterValue)
        this.renderOptionsForm(options)
    }

    fetchAdapterOptions(adapter) {
        const options = {
            flasher: {
                position: {
                    type: 'radio',
                    default: 'top-right',
                    options: ['top-right', 'top-left', 'top-center', 'bottom-right', 'bottom-left', 'bottom-center'],
                },
                direction: {
                    type: 'radio',
                    default: 'top',
                    options: ['top', 'bottom'],
                },
                timeout: {
                    type: 'radio',
                    default: 5000,
                    options: [0, 3000, 9000],
                },
            },
            toastr: {
                closeButton: { type: 'checkbox', default: true },
            },
        }
        return options[adapter] || {}
    }

    renderOptionsForm(options) {
        let formHTML = '<form id="options-form" class="space-y-4">'
        Object.entries(options).forEach(([key, option]) => {
            formHTML += this.optionToFormHTML(key, option)
        })
        formHTML += '</form>'
        this.optionsContainerTarget.innerHTML = formHTML
    }

    optionToFormHTML(key, option) {
        let inputHTML = ''
        if (option.type === 'radio') {
            inputHTML = option.options.map((opt) => `
            <div class="flex items-center w-1/4">
                <input id="${key}-${opt}" type="radio" name="${key}" value="${opt}" class="text-indigo-600 border-gray-300 focus:ring-indigo-500" ${opt === option.default ? 'checked' : ''}>
                <label for="${key}-${opt}" class="py-1 px-4 text-sm font-medium text-gray-800 whitespace-nowrap">${opt}</label>
            </div>
        `).join('')
        } else if (option.type === 'checkbox') {
            inputHTML = `
            <div class="flex items-center w-1/4">
                <input id="${key}" type="checkbox" name="${key}" class="text-indigo-600 border-gray-300 focus:ring-indigo-500 rounded" ${option.default ? 'checked' : ''}>
                <label for="${key}" class="py-1 px-4 text-sm font-medium text-gray-800">${key}</label>
            </div>
        `
        } else {
            inputHTML = `<div class="w-1/4"><input type="${option.type}" name="${key}" value="${option.default}" class="hidden"></div>`
        }
        return `
        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-700">${key}</label>
            <div class="mt-2 grid grid-cols-3">
                ${inputHTML}
            </div>
        </div>
    `
    }

    showNotification(event) {
        event.preventDefault()
        const options = this.collectOptions()
        const message = this.messageTarget.value
        const title = this.titleTarget.value
        const type = this.typeValue

        this.updateCodeSnippet()
        flasher.use(this.adapterValue).flash(type, message, title, options)
    }

    collectOptions() {
        const form = this.optionsContainerTarget.querySelector('#options-form')
        const formData = new FormData(form)
        const options = {}
        formData.forEach((value, key) => {
            options[key] = value
        })
        return options
    }

    updateCodeSnippet() {
        const options = this.collectOptions()
        const message = this.messageTarget.value
        const title = this.titleTarget.value
        const type = this.typeValue

        const optionsString = this.optionsToOptionMethods(options)

        const codeFunction = this.adapterValue === 'toastr' ? 'toastr' : 'flash'
        const formattedOptions = optionsString ? `\n${optionsString}` : ''
        this.codeSnippetTarget.textContent = `${codeFunction}()${formattedOptions}\n\t->${type}('${message}', '${title}');`
        Prism.highlightElement(this.codeSnippetTarget)
    }

    optionsToOptionMethods(options) {
        return Object.entries(options).map(([key, value]) => {
            const formattedValue = typeof value === 'string' ? `'${value}'` : value
            return `\t->option('${key}', ${formattedValue})`
        }).join('\n')
    }
}
