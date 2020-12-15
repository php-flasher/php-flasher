PHPFlasher.addFactory('toastr', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var notification = data.notification;
        toastr[notification.type](notification.message, notification.title, notification.options);
    };

    exports.renderOptions = function (options) {
        toastr.options = options;
    };

    return exports;
})());
