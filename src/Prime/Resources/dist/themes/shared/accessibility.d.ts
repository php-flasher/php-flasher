export type NotificationType = 'success' | 'info' | 'warning' | 'error';
export interface A11yAttributes {
    role: 'alert' | 'status';
    ariaLive: 'assertive' | 'polite';
    ariaAtomic: 'true';
}
export declare function getA11yAttributes(type: NotificationType | string): A11yAttributes;
export declare function getA11yString(type: NotificationType | string): string;
export declare function getCloseButtonA11y(type: NotificationType | string): string;
