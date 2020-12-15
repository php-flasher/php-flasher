PHPFlasher.addFactory('pnotify', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var notification = data.notification;
        var options = {
            text: notification.message,
            type: notification.type,
            ...notification.options
        }

        new PNotify(options);
    };

    exports.renderOptions = function (options) {
        PNotify.defaults = options;
    };

    return exports;
})());
