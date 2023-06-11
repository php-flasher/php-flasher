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
        $jsonOptions = json_encode($response->toArray());
        $context = $response->getContext();

        if (isset($context['envelopes_only']) && true === $context['envelopes_only']) {
            return $jsonOptions ?: '';
        }

        $mainScript = $response->getRootScript();
        $placeholder = self::FLASHER_FLASH_BAG_PLACE_HOLDER;

        return $this->createJavascript($jsonOptions, $mainScript, $placeholder);
    }

    private function createJavascript(string $jsonOptions, string $mainScript, string $placeholder): string
    {
        return <<<JAVASCRIPT
<script type="text/javascript" class="flasher-js">
(function() {
    const mainScript = '{$mainScript}';

    const deepMergeArrays = (first, second) => {
        return [...first, ...second.filter(item => !first.includes(item))];
    };

    const deepMergeObjects = (first, second) => {
        for (const [key, value] of Object.entries(second)) {
            first[key] = first.hasOwnProperty(key) ? { ...first[key], ...value } : value;
        }
        return first;
    };

    const mergeOptions = (...options) => {
        return options.reduce((result, option) => {
            result.envelopes.push(...option.envelopes);
            result.scripts = deepMergeArrays(result.scripts, option.scripts);
            result.styles = deepMergeArrays(result.styles, option.styles);
            result.options = deepMergeObjects(result.options, option.options);
            result.context = { ...result.context, ...option.context };
            return result;
        }, { envelopes: [], scripts: [], styles: [], options: {}, context: {} });
    }

    const optionsRegistry = [];
    optionsRegistry.push({$jsonOptions});
    {$placeholder}
    const options = mergeOptions(...optionsRegistry);

    const renderOptions = (options) => {
        if(!window.hasOwnProperty('flasher')) {
            console.error('Flasher is not loaded');
            return;
        }

        requestAnimationFrame(function () {
            window.flasher.render(options);
        });
    }

    const render = (options) => {
        if ('loading' !== document.readyState) {
            renderOptions(options);

            return;
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderOptions(options);
        });
    }

    if (document.querySelector('script.flasher-js').length) {
        document.addEventListener('flasher:render', (e) => render(e.detail));
    }

    if (window.hasOwnProperty('flasher') || !mainScript || document.querySelector('script[src="' + mainScript + '"]')) {
        render(options);
    } else {
        const tag = document.createElement('script');
        tag.setAttribute('src', mainScript);
        tag.setAttribute('type', 'text/javascript');
        tag.onload = () => render(options);

        document.head.appendChild(tag);
    }
})();
</script>
JAVASCRIPT;
    }
}
