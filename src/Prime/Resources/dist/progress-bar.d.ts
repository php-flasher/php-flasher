export declare function addProgressBar(notification: HTMLElement, { timeout, fps, progressBar }: {
    timeout: number;
    fps: number;
    progressBar: boolean | {
        top: boolean;
        right: boolean;
        bottom: boolean;
        left: boolean;
    };
}, callback: CallableFunction): void;
