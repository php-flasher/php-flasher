export function addProgressBar(notification: HTMLElement, { timeout, fps, progressBar }: { timeout: number; fps: number; progressBar: boolean | { top: boolean; right: boolean; bottom: boolean; left: boolean; } }, callback: CallableFunction): void {
    if (timeout <= 0 || fps <= 0 || progressBar === false) return;

    let barConfig = typeof progressBar === 'object' ? progressBar : {};
    barConfig = { top: false, right: false, bottom: true, left: false, ...barConfig };

    const totalTime: number = timeout;
    let elapsedTime: number = 0;

    // @ts-ignore
    const activeSides = ['top', 'right', 'bottom', 'left'].filter(side => barConfig[side]);

    const bars: HTMLElement[] = [];
    let totalLength: number = 0;
    activeSides.forEach(side => {
        let barContainer = notification.querySelector(`.fl-progress-${side}`);
        if (!barContainer) {
            barContainer = document.createElement('div') as HTMLElement;
            barContainer.className = `fl-progress-${side}`;
            notification.appendChild(barContainer);
        }

        let bar = barContainer.querySelector('.fl-progress');
        if (!bar) {
            bar = document.createElement('div') as HTMLElement;
            bar.className = 'fl-progress';
            barContainer.appendChild(bar);
        }
        bars.push(bar as HTMLElement);

        if (side === 'top' || side === 'bottom') {
            totalLength += notification.offsetWidth;
        } else { // 'right' or 'left'
            totalLength += notification.offsetHeight;
        }
    });

    const segmentDuration = totalTime / activeSides.length;
    let currentBarIndex = 0;
    let segmentElapsedTime = 0;

    const updateProgress = (): void => {
        elapsedTime += 1000 / fps;
        segmentElapsedTime += 1000 / fps;

        const currentSide = activeSides[currentBarIndex];
        const progressPercentage = Math.min(1, segmentElapsedTime / segmentDuration) * 100;

        if (currentSide === 'top' || currentSide === 'bottom') {
            bars[currentBarIndex].style.width = `${progressPercentage}%`;
        } else if (currentSide === 'right' || currentSide === 'left') {
            bars[currentBarIndex].style.height = `${progressPercentage}%`;
        }

        // Check if it's time to move to the next bar.
        if (segmentElapsedTime >= segmentDuration) {
            segmentElapsedTime = 0; // Reset for the next segment.
            currentBarIndex++;
            // Loop back to the first bar if we've gone through all active sides.
            if (currentBarIndex >= activeSides.length) {
                currentBarIndex = 0;
            }
        }

        if (elapsedTime >= totalTime) {
            // Ensure all active bars are completed.
            bars.forEach((bar, index) => {
                const side = activeSides[index];
                if (side === 'top' || side === 'bottom') {
                    bar.style.width = '100%';
                } else if (side === 'right' || side === 'left') {
                    bar.style.height = '100%';
                }
            });

            clearInterval(intervalId);

            if (typeof callback === 'function') {
                callback();
            }
        }
    };

    let intervalId: number = window.setInterval(updateProgress, 1000 / fps);
    notification.addEventListener('mouseover', () => clearInterval(intervalId));
    notification.addEventListener('mouseout', () => {
        // Ensure the progress continues smoothly from the current state.
        if (elapsedTime < totalTime) {
            intervalId = window.setInterval(updateProgress, 1000 / fps);
        }
    });
}
