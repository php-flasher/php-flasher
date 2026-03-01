export type IconType = 'success' | 'info' | 'warning' | 'error' | 'close'
export type IconSize = 'sm' | 'md' | 'lg' | number

export interface IconConfig {
    size?: IconSize
    className?: string
}

const sizeMap: Record<string, number> = {
    sm: 16,
    md: 20,
    lg: 24,
}

const iconPaths: Record<IconType, string> = {
    success:
        'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
    error: 'M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z',
    warning:
        'M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z',
    info: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z',
    close: 'M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z',
}

export function getIcon(type: IconType, config: IconConfig = {}): string {
    const { size = 'md', className = '' } = config
    const dimension = typeof size === 'number' ? size : sizeMap[size]
    const path = iconPaths[type]

    if (!path) {
        return ''
    }

    const classAttr = className ? ` class="${className}"` : ''

    return `<svg${classAttr} viewBox="0 0 24 24" width="${dimension}" height="${dimension}" aria-hidden="true"><path fill="currentColor" d="${path}"/></svg>`
}

export function getCloseIcon(config: IconConfig = {}): string {
    return getIcon('close', { size: 'sm', ...config })
}

export function getTypeIcon(
    type: string,
    config: IconConfig = {}
): string {
    if (type === 'success' || type === 'error' || type === 'warning' || type === 'info') {
        return getIcon(type, config)
    }
    return ''
}
