PHPFlasher.addFactory('sweet_alert', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var notification = data.notification;
        var options = {
            title: ' ',
            text: notification.message,
            icon: notification.type,
            ...notification.options
        }

        window.SwalToast.fire(options);
    };

    exports.renderOptions = function (options) {
        if ("undefined" === typeof window.SwalToast) {
            window.SwalToast = Swal.mixin(options);
        }
    };

    return exports;
})());
