import { Properties } from 'csstype';
import { Envelope, Options, Theme } from './types';
import { AbstractPlugin } from './plugin';

export default class FlasherPlugin extends AbstractPlugin {
  private theme: Theme;
  private options = {
    timeout: 5000,
    fps: 30,
    position: 'top-right',
    direction: 'top',
    rtl: false,
    style: {} as Properties,
    darkMode: 'media',
  };

  constructor(theme: Theme) {
    super();

    this.theme = theme;
  }

  public renderEnvelopes(envelopes: Envelope[]): void {
    const onContainerReady = (envelopes: Envelope[]) => {
      envelopes.forEach((envelope) => {
        const options = { ...this.options, ...envelope.options };

        const container = this.createContainer(options);
        this.addToContainer(container, envelope, options);
      });
    };

    if (['interactive', 'complete'].includes(document.readyState)) {
      onContainerReady(envelopes);
    } else {
      document.addEventListener('DOMContentLoaded', () =>
        onContainerReady(envelopes),
      );
    }
  }

  public renderOptions(options: Options): void {
    this.options = { ...this.options, ...options };
    this.applyDarkMode();
  }

  private createContainer(options: {
    position: string;
    style: Properties;
  }): HTMLDivElement {
    let container = document.querySelector(
      `.fl-main-container[data-position="${options.position}"]`,
    ) as HTMLDivElement;
    if (container) {
      container.dataset.turboCache = 'false';
      return container;
    }

    container = document.createElement('div');
    container.classList.add('fl-main-container');
    container.dataset.position = options.position;
    container.dataset.turboCache = 'false';

    Object.keys(options.style).forEach((key: string) => {
      container.style.setProperty(
        key,
        options.style[key as keyof Properties] as string,
      );
    });

    document.body.append(container);

    return container;
  }

  private addToContainer(
    container: HTMLDivElement,
    envelope: Envelope,
    options: { direction: string; timeout: number; fps: number; rtl: boolean },
  ): void {
    const template = this.stringToHTML(this.theme.render(envelope));
    template.classList.add('fl-container');

    this.appendNotification(container, template, options);
    this.renderProgressBar(template, options);
    this.handleClick(template);
  }

  private appendNotification(
    container: HTMLElement,
    template: HTMLElement,
    options: { direction: string; rtl: boolean },
  ): void {
    if (options.direction === 'bottom') {
      container.append(template);
    } else {
      container.prepend(template);
    }

    if (options.rtl) {
      template.classList.add('fl-rtl');
    }

    requestAnimationFrame(() => template.classList.add('fl-show'));
  }

  private removeNotification(template: HTMLElement) {
    const container = template.parentElement as HTMLDivElement;

    template.classList.remove('fl-show');
    template.addEventListener('transitionend', () => {
      template.remove();

      if (!container.hasChildNodes()) {
        container.remove();
      }
    });
  }

  private handleClick(template: HTMLElement) {
    template.addEventListener('click', () => this.removeNotification(template));
  }

  private renderProgressBar(
    template: HTMLElement,
    { timeout, fps }: { timeout: number; fps: number },
  ) {
    if (!timeout || timeout <= 0) {
      return;
    }

    const progressBar = document.createElement('span');
    progressBar.classList.add('fl-progress');

    template.querySelector('.fl-progress-bar')?.append(progressBar);

    const increment = 100 / (timeout / (1000 / fps));
    let width = 0;

    const showProgress = () => {
      width += increment;
      progressBar.style.width = `${width}%`;

      if (width >= 100) {
        clearInterval(interval);
        this.removeNotification(template);
      }
    };

    let interval: number;

    const startProgress = (): void => {
      interval = window.setInterval(showProgress, 1000 / fps);
    };

    const stopProgress = (): void => {
      clearInterval(interval);
    };

    template.addEventListener('mouseover', stopProgress);
    template.addEventListener('mouseout', startProgress);

    startProgress();
  }

  private applyDarkMode(): void {
    const [mode, className = 'dark'] = [].concat(
      this.options.darkMode as unknown as ConcatArray<never>,
    );

    const shouldApplyDarkMode =
      (mode === 'media' &&
        window.matchMedia &&
        window.matchMedia('(prefers-color-scheme: dark)').matches) ||
      (mode === 'class' && document.body.classList.contains(className));

    document.body.classList.toggle('fl-dark', shouldApplyDarkMode);
  }

  private stringToHTML(str: string): HTMLElement {
    const dom = document.createElement('div');
    dom.innerHTML = str.trim();
    return dom.firstElementChild as HTMLElement;
  }
}
