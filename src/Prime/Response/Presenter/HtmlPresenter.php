<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class HtmlPresenter implements PresenterInterface
{
    const FLASHER_FLASH_BAG_PLACE_HOLDER = 'FLASHER_FLASH_BAG_PLACE_HOLDER';
    const HEAD_END_PLACE_HOLDER = '</head>';
    const BODY_END_PLACE_HOLDER = '</body>';

    /**
     * {@inheritdoc}
     */
    public function render(Response $response)
    {
        $options = json_encode($response->toArray(true));
        $context = $response->getContext();

        if (isset($context['envelopes_only']) && true === $context['envelopes_only']) {
            return $options;
        }

        $rootScript = $response->getRootScript();
        $placeHolder = self::FLASHER_FLASH_BAG_PLACE_HOLDER;

        return <<<JAVASCRIPT
<script type="text/javascript" class="flasher-js">
(function() {
    var rootScript = '{$rootScript}';
    var {$placeHolder} = {};
    var options = mergeOptions({$options}, {$placeHolder});

    function mergeOptions(first, second) {
        return {
            context: merge(first.context || {}, second.context || {}),
            envelopes: merge(first.envelopes || [], second.envelopes || []),
            options: merge(first.options || {}, second.options || {}),
            scripts: merge(first.scripts || [], second.scripts || []),
            styles: merge(first.styles || [], second.styles || []),
        };
    }

    function merge(first, second) {
        if (Array.isArray(first) && Array.isArray(second)) {
            return first.concat(second).filter(function(item, index, array) {
                return array.indexOf(item) === index;
            });
        }

        return Object.assign({}, first, second);
    }

    function renderOptions(options) {
        if(!window.hasOwnProperty('flasher')) {
            console.error('Flasher is not loaded');
            return;
        }

        requestAnimationFrame(function () {
            window.flasher.render(options);
        });
    }

    function render(options) {
        if ('loading' !== document.readyState) {
            renderOptions(options);

            return;
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderOptions(options);
        });
    }

    if (1 === document.querySelectorAll('script.flasher-js').length) {
        document.addEventListener('flasher:render', function (event) {
            render(event.detail);
        });
    }

    if (window.hasOwnProperty('flasher') || !rootScript || document.querySelector('script[src="' + rootScript + '"]')) {
        render(options);
    } else {
        var tag = document.createElement('script');
        tag.setAttribute('src', rootScript);
        tag.setAttribute('type', 'text/javascript');
        tag.onload = function () {
            render(options);
        };

        document.head.appendChild(tag);
    }
})();
</script>
JAVASCRIPT;
    }
}
