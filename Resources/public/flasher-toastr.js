PHPFlasher.addFactory('toastr', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        toastr[data.type](data.message, data.title, data.options);
    };

    exports.renderOptions = function (options) {
        toastr.options = options;
    };

    return exports;
})());
