/**
 * @package PHPFlasher
 * @author Younes ENNAJI
 * @license MIT
 */
class AbstractPlugin {
    success(message, title, options) {
        this.flash('success', message, title, options);
    }
    error(message, title, options) {
        this.flash('error', message, title, options);
    }
    info(message, title, options) {
        this.flash('info', message, title, options);
    }
    warning(message, title, options) {
        this.flash('warning', message, title, options);
    }
    flash(type, message, title, options) {
        let normalizedType;
        let normalizedMessage;
        let normalizedTitle;
        let normalizedOptions = {};
        if (typeof type === 'object') {
            normalizedOptions = Object.assign({}, type);
            normalizedType = normalizedOptions.type;
            normalizedMessage = normalizedOptions.message;
            normalizedTitle = normalizedOptions.title;
            delete normalizedOptions.type;
            delete normalizedOptions.message;
            delete normalizedOptions.title;
        }
        else if (typeof message === 'object') {
            normalizedOptions = Object.assign({}, message);
            normalizedType = type;
            normalizedMessage = normalizedOptions.message;
            normalizedTitle = normalizedOptions.title;
            delete normalizedOptions.message;
            delete normalizedOptions.title;
        }
        else if (typeof title === 'object') {
            normalizedOptions = Object.assign({}, title);
            normalizedType = type;
            normalizedMessage = message;
            normalizedTitle = normalizedOptions.title;
            delete normalizedOptions.title;
        }
        else {
            normalizedType = type;
            normalizedMessage = message;
            normalizedTitle = title;
            normalizedOptions = options || {};
        }
        if (!normalizedType) {
            throw new Error('Type is required for notifications');
        }
        if (normalizedMessage === undefined || normalizedMessage === null) {
            throw new Error('Message is required for notifications');
        }
        const envelope = {
            type: normalizedType,
            message: normalizedMessage,
            title: normalizedTitle || normalizedType,
            options: normalizedOptions,
            metadata: {
                plugin: '',
            },
        };
        this.renderOptions(normalizedOptions);
        this.renderEnvelopes([envelope]);
    }
}

export { AbstractPlugin };
