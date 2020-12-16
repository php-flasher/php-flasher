PHPFlasher.addFactory('template', (function () {
    'use strict';

    var exports = {};
    var options = {
        timeout: 5000,
        fps: 30,
        position: 'top-right',
        direction: 'top'
    };

    exports.render = function (envelope) {
        renderEnvelope(envelope);
    };

    exports.renderOptions = function (_setting) {
        options = extend({}, options, _setting);
    };

    var renderEnvelope = function (envelope) {
        var position = options.position;

        if (undefined !== envelope.options && undefined !== envelope.options.position) {
            position = envelope.options.position;
        }

        var container = document.getElementById('flasher-container-' + position);
        if (null === container) {
            container = document.createElement('div');
            container.id = "flasher-container-" + options.position;
            container.style.position = "fixed";
            container.style.maxWidth = "304px";
            container.style.width = "100%";

            switch (options.position) {
                case "top-left":
                    container.style.top = 0;
                    container.style.left = "0.5em";
                    break;
                case "top-right":
                    container.style.top = 0;
                    container.style.right = "0.5em";
                    break;
                case "bottom-left":
                    container.style.bottom = 0;
                    container.style.left = "0.5em";
                    break;
                case "bottom-right":
                default:
                    container.style.bottom = 0;
                    container.style.right = "0.5em";
                    break;
            }
            document.getElementsByTagName('body')[0].appendChild(container);
        }

        var template = stringToHTML(envelope.template);
        template.style.transition = '0.8s';

        switch (options.direction) {
            case "top":
                container.insertBefore(template, container.firstChild);
                break;
            case "bottom":
            default:
                container.appendChild(template);
                break;
        }

        var progressBar = template.querySelector('.flasher-progress');
        if (null !== progressBar) {
            var width = 0;
            var lapse = 1000 / options.fps;

            var showProgress = function () {
                width++;
                var percent = (1 - lapse * width / options.timeout) * 100;
                progressBar.style.width = percent + '%';

                if (percent <= 0) {
                    template.style.opacity = 0;
                    clearInterval(progress);

                    setTimeout(function () {
                        template.remove();
                    }, 900);
                }
            }

            var progress = setInterval(showProgress, lapse);

            template.addEventListener('mouseover', function () {
                clearInterval(progress);
            });

            template.addEventListener("mouseout", function () {
                progress = setInterval(showProgress, lapse);
            });
        }
    }

    var stringToHTML = function (str) {
        var support = (function () {
            if (!window.DOMParser) return false;
            var parser = new DOMParser();
            try {
                parser.parseFromString('x', 'text/html');
            } catch (err) {
                return false;
            }
            return true;
        })();

        if (support) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(str, 'text/html');
            return doc.body.firstChild;
        }

        var dom = document.createElement('div');
        dom.innerHTML = str;
        return dom.firstElementChild;
    };

    var extend = function (out) {
        out = out || {};

        for (var i = 1; i < arguments.length; i++) {
            if (!arguments[i])
                continue;

            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key))
                    out[key] = arguments[i][key];
            }
        }

        return out;
    };

    return exports;
})());
