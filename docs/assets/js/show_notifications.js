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

    factory.info('Welcome back', 'Info', options)

    if (['sweetalert'].includes(handler)) {
        return
    }

    showNotifications([
        () => factory.error('Oops! Something went wrong!', 'Error', options),
        () => factory.warning('Are you sure you want to proceed ?', 'Warning', options),
        () => factory.success('Data has been saved successfully!', 'Success', options),
    ])
}
