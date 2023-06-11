<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class HtmlPresenter implements PresenterInterface
{
    public const FLASHER_FLASH_BAG_PLACE_HOLDER = '/** FLASHER_FLASH_BAG_PLACE_HOLDER **/';

    public const HEAD_END_PLACE_HOLDER = '</head>';

    public const BODY_END_PLACE_HOLDER = '</body>';

    public function render(Response $response): string
    {
        $jsonOptions = json_encode($response->toArray()) ?: '';
        $context = $response->getContext();

        if (isset($context['envelopes_only']) && true === $context['envelopes_only']) {
            return $jsonOptions;
        }

        $mainScript = $response->getRootScript();
        $placeholder = self::FLASHER_FLASH_BAG_PLACE_HOLDER;

        return $this->renderJavascript($jsonOptions, $mainScript, $placeholder);
    }

    private function renderJavascript(string $jsonOptions, string $mainScript, string $placeholder): string
    {
        return <<<JAVASCRIPT
<script type="text/javascript" class="flasher-js">
(function(window, document) {
    const merge = (first, second) => {
        if (Array.isArray(first) && Array.isArray(second)) {
            return [...first, ...second.filter(item => !first.includes(item))];
        }

        if (typeof first === 'object' && typeof second === 'object') {
            for (const [key, value] of Object.entries(second)) {
                first[key] = key in first ? { ...first[key], ...value } : value;
            }
            return first;
        }

        return undefined;
    };

    const mergeOptions = (...options) => {
        const result = {};

        options.forEach(option => {
            Object.entries(option).forEach(([key, value]) => {
                result[key] = key in result ? merge(result[key], value) : value;
            });
        });

        return result;
    };

    const renderCallback = (options) => {
        if(!window.flasher) {
            throw new Error('Flasher is not loaded');
        }

        window.flasher.render(options);
    };

    const render = (options) => {
        if (options instanceof Event) {
            options = options.detail;
        }

        if (['interactive', 'complete'].includes(document.readyState)) {
            renderCallback(options);
        } else {
            document.addEventListener('DOMContentLoaded', () => renderCallback(options));
        }
    };

    const addScriptAndRender = (options) => {
        const mainScript = '{$mainScript}';

        if (window.flasher || !mainScript || document.querySelector('script[src="' + mainScript + '"]')) {
            render(options);
        } else {
            const tag = document.createElement('script');
            tag.src = mainScript;
            tag.type = 'text/javascript';
            tag.onload = () => render(options);

            document.head.appendChild(tag);
        }
    };

    const addRenderListener = () => {
        if (1 === document.querySelectorAll('script.flasher-js').length) {
            document.addEventListener('flasher:render', render);
        }
    };

    const options = [];
    options.push({$jsonOptions});
    {$placeholder}
    addScriptAndRender(mergeOptions(...options));
    addRenderListener();
})(window, document);
</script>
JAVASCRIPT;
    }
}
