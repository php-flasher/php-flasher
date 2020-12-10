PHPFlasher.addFactory('sweet_alert', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var options = {
            text: data.message,
            icon: data.type,
            ...data.options
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
