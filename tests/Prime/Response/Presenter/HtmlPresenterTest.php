<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response\Presenter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Flasher\Prime\Response\Response;
use Livewire\LivewireManager;
use PHPUnit\Framework\TestCase;

final class HtmlPresenterTest extends TestCase
{
    public function testArrayPresenter(): void
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification);

        $scriptTagWithNonce = '';
        $livewireListener = $this->getLivewireListenerScript();

        $response = <<<JAVASCRIPT
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
                        const mainScript = '';

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
                    options.push({"envelopes":[{"title":"PHPFlasher","message":"success message","type":"success","options":[],"metadata":[]},{"title":"yoeunes\/toastr","message":"warning message","type":"warning","options":[],"metadata":[]}],"scripts":[],"styles":[],"options":[],"context":[]});
                    /** {--FLASHER_REPLACE_ME--} **/
                    addScriptAndRender(mergeOptions(...options));
                    addRenderListener();
                })(window, document);
            </script>
        JAVASCRIPT;

        $presenter = new HtmlPresenter();

        $this->assertSame($response, $presenter->render(new Response($envelopes, [])));
    }

    public function testItRenderOnlyEnvelopesAsJsonObject(): void
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification);

        $response = '{"envelopes":[{"title":"PHPFlasher","message":"success message","type":"success","options":[],"metadata":[]},{"title":"yoeunes\/toastr","message":"warning message","type":"warning","options":[],"metadata":[]}],"scripts":[],"styles":[],"options":[],"context":{"envelopes_only":true}}';

        $presenter = new HtmlPresenter();

        $this->assertSame($response, $presenter->render(new Response($envelopes, ['envelopes_only' => true])));
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
