PHPFlasher.addFactory('noty', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var notification = data.notification;
        var options = {
            text: notification.message,
            type: notification.type,
            ...notification.options
        }

        new Noty(options).show();
    };

    exports.renderOptions = function (options) {
        Noty.overrideDefaults(options);
    };

    return exports;
})());
