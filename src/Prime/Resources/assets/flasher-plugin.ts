import { Properties } from 'csstype';
import { Envelope, Options, Theme } from './types';
import { AbstractPlugin } from './plugin';
import { addProgressBar } from './progress-bar';

import "./themes/root.scss";

export default class FlasherPlugin extends AbstractPlugin {
    private theme: Theme;
    private options = {
        timeout: 5000,
        timeouts: {
            error: 0,
            warning: 0,
        },
        fps: 30,
        position: 'top-right',
        direction: 'top',
        rtl: false,
        style: {} as Properties,
        progressBar: {
            top: false,
            right: false,
            bottom: true,
            left: false,
        },
    };

    constructor(theme: Theme) {
        super();

        this.theme = theme;
    }

    public renderEnvelopes(envelopes: Envelope[]): void {
        const render = () => envelopes.forEach(envelope => {
                // @ts-ignore
            const typeTimeout = this.options.timeouts[envelope.type] ?? this.options.timeout;
            const options = { ...this.options, ...envelope.options, timeout: envelope.options.timeout ?? typeTimeout };

            this.addToContainer(this.createContainer(options), envelope, options);
        });

        document.readyState === 'loading'
            ? document.addEventListener('DOMContentLoaded', render)
            : render();
    }

    public renderOptions(options: Options): void {
        this.options = { ...this.options, ...options };
    }

    private createContainer(options: { position: string, style: Properties }): HTMLDivElement {
        let container = document.querySelector(`.fl-main-container[data-position="${options.position}"]`) as HTMLDivElement;

        if (!container) {
            container = document.createElement('div');
            container.className = 'fl-main-container';
            container.dataset.position = options.position;
            Object.entries(options.style).forEach(([key, value]) => container.style.setProperty(key, value));
            document.body.appendChild(container);
        }

        container.dataset.turboCache = 'false';

        return container;
    }

    private addToContainer(container: HTMLDivElement, envelope: Envelope, options: { direction: string; timeout: number; fps: number; rtl: boolean; progressBar: boolean|{top: boolean; right: boolean; bottom: boolean; left: boolean; } }): void {
        const notification = this.stringToHTML(this.theme.render(envelope));

        notification.classList.add('fl-container' + (options.rtl ? ' fl-rtl' : ''));
        options.direction === 'bottom' ? container.append(notification) : container.prepend(notification);

        requestAnimationFrame(() => notification.classList.add('fl-show'));

        notification.querySelector('.fl-close')?.addEventListener('click', (event) => {
            event.stopPropagation();
            this.removeNotification(notification);
        });

        addProgressBar(notification, options, () => this.removeNotification(notification));
    }

    private removeNotification(notification: HTMLElement) {
        notification.classList.remove('fl-show');
        notification.ontransitionend = () => {
            if (!notification.parentElement?.hasChildNodes()) {
                notification.parentElement?.remove();
            }
            notification.remove();
        };
    }

    private stringToHTML(str: string): HTMLElement {
        const template = document.createElement('template');
        template.innerHTML = str.trim();
        return template.content.firstElementChild as HTMLElement;
    }
}
