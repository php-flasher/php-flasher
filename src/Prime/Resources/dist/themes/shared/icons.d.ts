export type IconType = 'success' | 'info' | 'warning' | 'error' | 'close';
export type IconSize = 'sm' | 'md' | 'lg' | number;
export interface IconConfig {
    size?: IconSize;
    className?: string;
}
export declare function getIcon(type: IconType, config?: IconConfig): string;
export declare function getCloseIcon(config?: IconConfig): string;
export declare function getTypeIcon(type: string, config?: IconConfig): string;
