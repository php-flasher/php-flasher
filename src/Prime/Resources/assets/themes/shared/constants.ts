export const CLASS_NAMES = {
    container: 'fl-container',
    wrapper: 'fl-wrapper',
    content: 'fl-content',

    message: 'fl-message',
    title: 'fl-title',
    text: 'fl-text',

    icon: 'fl-icon',
    iconWrapper: 'fl-icon-wrapper',

    actions: 'fl-actions',
    close: 'fl-close',

    progressBar: 'fl-progress-bar',
    progress: 'fl-progress',

    show: 'fl-show',
    sticky: 'fl-sticky',
    rtl: 'fl-rtl',

    type: (type: string) => `fl-${type}`,
    theme: (name: string) => `fl-${name}`,
} as const

export const DEFAULT_TITLES: Record<string, string> = {
    success: 'Success',
    error: 'Error',
    warning: 'Warning',
    info: 'Information',
}

export const DEFAULT_TEXT = {
    dismissButton: 'DISMISS',
    closeLabel: (type: string) => `Close ${type} message`,
} as const

export function capitalizeType(type: string): string {
    return type.charAt(0).toUpperCase() + type.slice(1)
}

export function getTitle(title: string | undefined, type: string): string {
    return title || DEFAULT_TITLES[type] || capitalizeType(type)
}
