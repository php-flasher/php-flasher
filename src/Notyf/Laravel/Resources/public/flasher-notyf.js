PHPFlasher.addFactory('notyf', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        window.notyf.open(data);
    };

    exports.renderOptions = function (options) {
        if ("undefined" === typeof window.notyf) {
            window.notyf = new Notyf(options);
        }
    };

    return exports;
})());
