export type NotificationType = 'success' | 'info' | 'warning' | 'error'

export interface A11yAttributes {
    role: 'alert' | 'status'
    ariaLive: 'assertive' | 'polite'
    ariaAtomic: 'true'
}

export function getA11yAttributes(type: NotificationType | string): A11yAttributes {
    const isAlert = type === 'error' || type === 'warning'
    return {
        role: isAlert ? 'alert' : 'status',
        ariaLive: isAlert ? 'assertive' : 'polite',
        ariaAtomic: 'true',
    }
}

export function getA11yString(type: NotificationType | string): string {
    const attrs = getA11yAttributes(type)
    return `role="${attrs.role}" aria-live="${attrs.ariaLive}" aria-atomic="${attrs.ariaAtomic}"`
}

export function getCloseButtonA11y(type: NotificationType | string): string {
    return `aria-label="Close ${type} message"`
}
