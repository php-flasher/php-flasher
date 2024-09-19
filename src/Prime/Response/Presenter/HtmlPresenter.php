<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;
use Livewire\LivewireManager;

final class HtmlPresenter implements PresenterInterface
{
    public const FLASHER_REPLACE_ME = '/** {--FLASHER_REPLACE_ME--} **/';
    public const HEAD_END_PLACE_HOLDER = '</head>';
    public const BODY_END_PLACE_HOLDER = '</body>';

    /**
     * @throws \JsonException
     */
    public function render(Response $response): string
    {
        /** @var array{csp_script_nonce?: ?string, envelopes_only?: bool} $context */
        $context = $response->getContext();

        /** @var array{envelopes: array<int, array{metadata: array{html?: string}}>} $options */
        $options = $response->toArray();
        $html = '';

        foreach ($options['envelopes'] as $index => $envelope) {
            if (isset($envelope['metadata']['html'])) {
                $html .= $envelope['metadata']['html'];
                unset($options['envelopes'][$index]);
            }
        }

        $options['envelopes'] = array_values($options['envelopes']);
        $jsonOptions = json_encode($options, \JSON_THROW_ON_ERROR);

        if ($context['envelopes_only'] ?? false) {
            return $jsonOptions;
        }

        $nonce = $context['csp_script_nonce'] ?? null;

        $mainScript = $response->getMainScript();
        $replaceMe = self::FLASHER_REPLACE_ME;
        $nonceAttribute = $nonce ? " nonce='{$nonce}'" : '';
        $scriptTagWithNonce = $nonce ? "tag.setAttribute('nonce', '{$nonce}');" : '';
        $livewireListener = $this->getLivewireListenerScript();

        return $html.<<<JAVASCRIPT
            <script type="text/javascript" class="flasher-js"{$nonceAttribute}>
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
                            {$scriptTagWithNonce}
                            tag.onload = () => render(options);

                            document.head.appendChild(tag);
                        }
                    };

                    const addRenderListener = () => {
                        if (1 === document.querySelectorAll('script.flasher-js').length) {
                            document.addEventListener('flasher:render', render);
                        }

                        {$livewireListener}
                    };

                    const options = [];
                    options.push({$jsonOptions});
                    {$replaceMe}
                    addScriptAndRender(mergeOptions(...options));
                    addRenderListener();
                })(window, document);
            </script>
        JAVASCRIPT;
    }

    /**
     * Generate the script for Livewire event handling.
     */
    private function getLivewireListenerScript(): string
    {
        if (!class_exists(LivewireManager::class)) {
            return '';
        }

        return <<<JAVASCRIPT
            document.addEventListener('livewire:navigating', () => {
              document.querySelectorAll('.fl-no-cache').forEach(el => el.remove());
            });
        JAVASCRIPT;
    }
}
