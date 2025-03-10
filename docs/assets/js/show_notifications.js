import flasher from '@flasher/flasher'

function showNotifications(notifications) {
    if (notifications.length === 0) {
        return
    }

    setTimeout(() => {
        notifications[0]()
        showNotifications(notifications.slice(1))
    }, 1500)
}

export function showNotificationsForHandler(handler, options = {}) {
    const factory = flasher.use(handler)

    // Handle theme-based handlers with different positions
    const isThemeHandler = handler.startsWith('theme.')

    // Define position-specific options for theme handlers
    let infoOptions = { ...options }
    let errorOptions = { ...options }
    let warningOptions = { ...options }
    let successOptions = { ...options }

    if (isThemeHandler) {
        infoOptions = { ...options, position: 'bottom-right' }
        errorOptions = { ...options, position: 'bottom-right' }
        warningOptions = { ...options, position: 'bottom-right' }
        successOptions = { ...options, position: 'bottom-right' }
    }

    factory.info('Welcome back', 'Info', infoOptions)

    if (['sweetalert'].includes(handler)) {
        return
    }

    showNotifications([
        () => factory.error('Oops! Something went wrong!', 'Error', errorOptions),
        () => factory.warning('Are you sure you want to proceed?', 'Warning', warningOptions),
        () => factory.success('Data has been saved successfully!', 'Success', successOptions),
    ])
}
