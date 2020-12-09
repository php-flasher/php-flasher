var Flasher = function () {
    function Flasher() {
        this.factories = {};
    }

    var _proto = Flasher.prototype;

    _proto.create = function create(alias) {
        return this.factories[alias];
    };

    _proto.addFactory = function addFactory(alias, factory) {
        this.factories[alias] = factory;
    };

    return Flasher;
}();
