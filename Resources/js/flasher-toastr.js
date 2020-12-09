var ToastrFactory = function () {
    function ToastrFactory() {
    }

    var _proto = ToastrFactory.prototype;

    _proto.render = function render(data) {
        var message = data.message,
            title = data.title,
            options = data.options;

        toastr.success(message, title, options)
    };

    _proto.options = function options(_options) {
        toastr.options = options;
    };

    return ToastrFactory;
}();

PHPFlasher.addFactory('toastr', new ToastrFactory());
