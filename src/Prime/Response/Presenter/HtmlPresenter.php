<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class HtmlPresenter implements PresenterInterface
{
    public const FLASHER_FLASH_BAG_PLACE_HOLDER = 'FLASHER_FLASH_BAG_PLACE_HOLDER';

    public const HEAD_END_PLACE_HOLDER = '</head>';

    public const BODY_END_PLACE_HOLDER = '</body>';

    public function render(Response $response): string
    {
        $options = json_encode($response->toArray());
        $context = $response->getContext();

        if (isset($context['envelopes_only']) && true === $context['envelopes_only']) {
            return $options ?: '';
        }

        $rootScript = $response->getRootScript();
        $placeHolder = self::FLASHER_FLASH_BAG_PLACE_HOLDER;

        return <<<JAVASCRIPT
<script type="text/javascript" class="flasher-js">
(function() {
    const mainScript = '{$rootScript}';
    const optionsRegistry = new Map();
    const options = {$options};

    function mergeOptions(...options) {
        return options.reduce((result, option) => {
            // Merge envelopes
            result.envelopes.push(...option.envelopes);

            // Merge scripts and ensure uniqueness
            result.scripts.push(...option.scripts.filter(script => !result.scripts.includes(script)));

            // Merge styles and ensure uniqueness
            result.styles.push(...option.styles.filter(style => !result.styles.includes(style)));

            // Merge options and perform a deep merge
            for (const [key, value] of Object.entries(option.options)) {
              if (result.options.hasOwnProperty(key)) {
                result.options[key] = { ...result.options[key], ...value };
              } else {
                result.options[key] = value;
              }
            }

            // Merge context
            result.context = { ...result.context, ...option.context };

            return result;
        }, {envelopes: [], scripts: [], styles: [], options: {}, context: {}});
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
