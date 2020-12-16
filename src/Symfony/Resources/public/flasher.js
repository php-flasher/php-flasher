var PHPFlasher = (function () {
    'use strict';

    var exports = {};
    var factories = {};

    exports.render = function (_options) {
        exports.addStyles(getStyles(_options), function () {
            exports.addScripts(getScripts(_options), function () {
                exports.renderOptions(_options.options);
                exports.renderEnvelopes(_options.envelopes);
            });
        });
    };

    exports.addFactory = function (alias, factory) {
        factories[alias] = factory;
    };

    exports.addStyles = function (urls, callback) {
        if (0 === urls.length) {
            if ("function" === typeof callback) {
                callback();
            }

            return this;
        }

        if (null !== document.querySelector('link[href="' + urls[0] + '"]')) {
            return exports.addStyles(urls.slice(1), callback);
        }

        var tag = document.createElement('link');

        tag.href = urls[0];
        tag.type = 'text/css';
        tag.rel = 'stylesheet';
        tag.onload = function () {
            exports.addStyles(urls.slice(1), callback);
        };

        document.head.appendChild(tag);

        return this;
    };

    exports.addScripts = function (urls, callback) {
        if (0 === urls.length) {
            if ("function" === typeof callback) {
                callback();
            }

            return this;
        }

        if (null !== document.querySelector('script[src="' + urls[0] + '"]')) {
            return exports.addScripts(urls.slice(1), callback);
        }

        var tag = document.createElement('script');

        tag.src = urls[0];
        tag.type = 'text/javascript';
        tag.onload = function () {
            exports.addScripts(urls.slice(1), callback);
        };

        document.body.appendChild(tag);

        return this;
    };

    exports.renderOptions = function (options) {
        Object.keys(options).forEach(function (library) {
            factories[library].renderOptions(options[library]);
        });
    };

    exports.renderEnvelopes = function (envelopes) {
        envelopes.forEach(function (envelope) {
            factories[envelope.handler].render(envelope);
        })
    };

    var getStyles = function (_options) {
        var styles = _options.styles;

        _options.envelopes.forEach(function (envelope) {
            if (undefined !== envelope.context && undefined !== envelope.context.styles) {
                styles = styles.concat(envelope.context.styles);
            }
        });

        return styles.filter(function (item, pos) {
            return styles.indexOf(item) === pos;
        });
    }

    var getScripts = function (_options) {
        var scripts = _options.scripts;

        _options.envelopes.forEach(function (envelope) {
            if (undefined !== envelope.context && undefined !== envelope.context.scripts) {
                scripts = scripts.concat(envelope.context.scripts);
            }
        });

        return scripts.filter(function (item, pos) {
            return scripts.indexOf(item) === pos;
        });
    }

    return exports;
})();
