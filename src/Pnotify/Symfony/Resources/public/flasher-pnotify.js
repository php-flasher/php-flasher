PHPFlasher.addFactory('pnotify', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var options = {
            text: data.message,
            type: data.type,
            ...data.options
        }

        new PNotify(options);
    };

    exports.renderOptions = function (options) {
        PNotify.defaults = options;
    };

    return exports;
})());
