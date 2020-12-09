var NotyFactory = function () {
    function NotyFactory() {
    }

    var _proto = NotyFactory.prototype;

    _proto.render = function render(data) {
        var options = {
            text: data.message,
            type: data.type,
            ...data.options
        }
        new Noty(options).show();
    };

    _proto.options = function options(_options) {
        Noty.overrideDefaults(_options);
    };

    return NotyFactory;
}();

PHPFlasher.addFactory('noty', new NotyFactory());
