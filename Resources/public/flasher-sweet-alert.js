PHPFlasher.addFactory('sweet_alert', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var notification = data.notification;

        window.SwalToast.fire(notification.options);
    };

    exports.renderOptions = function (options) {
        if ("undefined" === typeof window.SwalToast) {
            window.SwalToast = Swal.mixin(options);
        }
    };

    return exports;
})());
