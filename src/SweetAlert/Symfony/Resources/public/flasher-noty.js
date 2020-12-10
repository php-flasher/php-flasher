PHPFlasher.addFactory('noty', (function () {
    'use strict';

    var exports = {};

    exports.render = function (data) {
        var options = {
            text: data.message,
            type: data.type,
            ...data.options
        }

        new Noty(options).show();
    };

    exports.renderOptions = function (options) {
        Noty.overrideDefaults(options);
    };

    return exports;
})());
