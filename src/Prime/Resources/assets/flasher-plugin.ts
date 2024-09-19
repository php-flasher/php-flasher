import './themes/index.scss'

import type { Properties } from 'csstype'
import type { Envelope, Options, Theme } from './types'
import { AbstractPlugin } from './plugin'

export default class FlasherPlugin extends AbstractPlugin {
    private theme: Theme
    private options = {
        timeout: null,
        timeouts: {
            success: 5000,
            info: 5000,
            error: 5000,
            warning: 5000,
        },
        fps: 30,
        position: 'top-right',
        direction: 'top',
        rtl: false,
        style: {} as Properties,
        escapeHtml: false,
    }

    constructor(theme: Theme) {
        super()

        this.theme = theme
    }

    public renderEnvelopes(envelopes: Envelope[]): void {
        const render = () =>
            envelopes.forEach((envelope) => {
                // @ts-expect-error
                const typeTimeout = this.options.timeout ?? this.options.timeouts[envelope.type] ?? 5000
                const options = {
                    ...this.options,
                    ...envelope.options,
                    timeout: envelope.options.timeout ?? typeTimeout,
                    escapeHtml: (envelope.options.escapeHtml ?? this.options.escapeHtml) as boolean,
                }

                this.addToContainer(this.createContainer(options), envelope, options)
            })

        document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', render) : render()
    }

    public renderOptions(options: Options): void {
        this.options = { ...this.options, ...options }
    }

    private createContainer(options: { position: string, style: Properties }): HTMLDivElement {
        let container = document.querySelector(`.fl-wrapper[data-position="${options.position}"]`) as HTMLDivElement

        if (!container) {
            container = document.createElement('div')
            container.className = 'fl-wrapper'
            container.dataset.position = options.position
            Object.entries(options.style).forEach(([key, value]) => container.style.setProperty(key, value))
            document.body.appendChild(container)
        }

        container.dataset.turboTemporary = ''

        return container
    }

    private addToContainer(container: HTMLDivElement, envelope: Envelope, options: { direction: string, timeout: number, fps: number, rtl: boolean, escapeHtml: boolean }): void {
        if (options.escapeHtml) {
            envelope.title = this.escapeHtml(envelope.title)
            envelope.message = this.escapeHtml(envelope.message)
        }

        const notification = this.stringToHTML(this.theme.render(envelope))

        notification.classList.add(...`fl-container${options.rtl ? ' fl-rtl' : ''}`.split(' '))
        options.direction === 'bottom' ? container.append(notification) : container.prepend(notification)

        requestAnimationFrame(() => notification.classList.add('fl-show'))

        notification.querySelector('.fl-close')?.addEventListener('click', (event) => {
            event.stopPropagation()
            this.removeNotification(notification)
        })

        this.addProgressBar(notification, options)
    }

    addProgressBar(notification: HTMLElement, { timeout, fps }: { timeout: number, fps: number }) {
        if (timeout <= 0 || fps <= 0) {
            return
        }

        const progressBarContainer = notification.querySelector('.fl-progress-bar')
        if (!progressBarContainer) {
            return
        }

        const progressBar = document.createElement('span')
        progressBar.classList.add('fl-progress')
        progressBarContainer.append(progressBar)

        const lapse = 1000 / fps
        let width = 0
        const updateProgress = () => {
            width += 1
            const percent = (1 - lapse * (width / timeout)) * 100
            progressBar.style.width = `${percent}%`

            if (percent <= 0) {
                // eslint-disable-next-line ts/no-use-before-define
                clearInterval(intervalId)
                this.removeNotification(notification)
            }
        }

        let intervalId: number = window.setInterval(updateProgress, lapse)
        notification.addEventListener('mouseout', () => intervalId = window.setInterval(updateProgress, lapse))
        notification.addEventListener('mouseover', () => clearInterval(intervalId))
    }

    private removeNotification(notification: HTMLElement) {
        notification.classList.remove('fl-show')
        notification.ontransitionend = () => {
            !notification.parentElement?.hasChildNodes() && notification.parentElement?.remove()
            notification.remove()
        }
    }

    private stringToHTML(str: string): HTMLElement {
        const template = document.createElement('template')
        template.innerHTML = str.trim()
        return template.content.firstElementChild as HTMLElement
    }

    private escapeHtml(str: string | null | undefined): string {
        if (str == null) {
            return ''
        }

        return str.replace(/[&<>"'`=\/]/g, (char) => {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                '\'': '&#39;',
                '`': '&#96;',
                '=': '&#61;',
                '/': '&#47;',
            }[char] as string
        })
    }
}
