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
        if (typeof type === 'object') {
            options = type;
            type = options.type;
            message = options.message;
            title = options.title;
        }
        else if (typeof message === 'object') {
            options = message;
            message = options.message;
            title = options.title;
        }
        else if (typeof title === 'object') {
            options = title;
            title = options.title;
        }
        if (undefined === message) {
            throw new Error('message option is required');
        }
        const envelope = {
            type,
            message,
            title: title || type,
            options: options || {},
            metadata: {
                plugin: '',
            },
        };
        this.renderOptions(options || {});
        this.renderEnvelopes([envelope]);
    }
}

export { AbstractPlugin };
