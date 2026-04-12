<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response\Presenter;

use Flasher\Prime\Asset\AssetManager;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Template\TemplateEngineInterface;
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
                        const mainScript = "";

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
                            document.addEventListener('turbo:before-cache', () => {
                                document.querySelectorAll('.fl-wrapper').forEach(el => el.remove());
                            });
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

    public function testRenderWithCspScriptNonce(): void
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $envelopes[] = new Envelope($notification);

        $presenter = new HtmlPresenter();
        $response = new Response($envelopes, ['csp_script_nonce' => 'test-nonce-123']);

        $result = $presenter->render($response);

        // Nonce should be HTML-escaped in attribute context
        $this->assertStringContainsString("nonce='test-nonce-123'", $result);
        // Nonce should be JSON-encoded in JavaScript context (uses double quotes)
        $this->assertStringContainsString('tag.setAttribute(\'nonce\', "test-nonce-123");', $result);
    }

    public function testRenderEscapesXssInNonce(): void
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $envelopes[] = new Envelope($notification);

        $presenter = new HtmlPresenter();
        // Attempt XSS injection via nonce
        $maliciousNonce = "'; alert('xss'); //";
        $response = new Response($envelopes, ['csp_script_nonce' => $maliciousNonce]);

        $result = $presenter->render($response);

        // The malicious payload should be escaped, not executed as code
        // HTML attribute should use htmlspecialchars escaping (ENT_HTML5 uses &apos;)
        $this->assertStringContainsString("nonce='&apos;; alert(&apos;xss&apos;); //'", $result);
        // JavaScript should use JSON encoding which escapes the single quotes
        $this->assertStringContainsString('tag.setAttribute(\'nonce\', "\'; alert(\'xss\'); \/\/");', $result);
        // The raw malicious string should NOT appear unescaped
        $this->assertStringNotContainsString("nonce=''; alert('xss');", $result);
    }

    public function testRenderEscapesXssInMainScript(): void
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $envelopes[] = new Envelope($notification);

        $presenter = new HtmlPresenter();
        // Attempt XSS injection via mainScript
        $maliciousScript = "'; alert('xss'); //";
        $response = new Response($envelopes, []);
        $response->setMainScript($maliciousScript);

        $result = $presenter->render($response);

        // The malicious payload should be JSON-encoded, preventing code execution
        $this->assertStringContainsString('const mainScript = "\'; alert(\'xss\'); \/\/";', $result);
        // The raw malicious string should NOT appear unescaped
        $this->assertStringNotContainsString("const mainScript = ''; alert('xss');", $result);
    }

    public function testRenderWithHtmlMetadata(): void
    {
        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setOption('metadata', ['html' => '<div>Custom HTML</div>']);

        $envelope = new Envelope($notification);

        $presenter = new HtmlPresenter();
        $response = new Response([$envelope], []);

        $result = $presenter->render($response);

        $this->assertStringContainsString('<script type="text/javascript" class="flasher-js">', $result);
    }

    public function testRenderEmbedsPrefixedMainScriptWhenPublicPathIsConfigured(): void
    {
        $presenter = new HtmlPresenter();
        $response = new Response([new Envelope(new Notification())], []);
        $response->setMainScript('/Symfony/vendor/flasher/flasher.min.js');

        $result = $presenter->render($response);

        $this->assertStringContainsString(
            'const mainScript = "\/Symfony\/vendor\/flasher\/flasher.min.js";',
            $result,
        );
    }

    public function testRenderEmbedsPrefixedStylesAndScriptsInJsonOptions(): void
    {
        $presenter = new HtmlPresenter();
        $response = new Response([new Envelope(new Notification())], []);
        $response->setMainScript('/Symfony/vendor/flasher/flasher.min.js');
        $response->addScripts(['/Symfony/vendor/flasher/extra.min.js']);
        $response->addStyles(['/Symfony/vendor/flasher/flasher.min.css']);

        $result = $presenter->render($response);

        $this->assertStringContainsString('"\/Symfony\/vendor\/flasher\/extra.min.js"', $result);
        $this->assertStringContainsString('"\/Symfony\/vendor\/flasher\/flasher.min.css"', $result);
    }

    public function testRenderEmbedsPrefixedUrlsInAjaxEnvelopesOnlyMode(): void
    {
        $presenter = new HtmlPresenter();
        $response = new Response([new Envelope(new Notification())], ['envelopes_only' => true]);
        $response->setMainScript('/Symfony/vendor/flasher/flasher.min.js');
        $response->addStyles(['/Symfony/vendor/flasher/flasher.min.css']);

        $result = $presenter->render($response);

        // envelopes_only mode returns raw JSON (not wrapped in <script>).
        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertIsArray($decoded);
        $this->assertSame(['/Symfony/vendor/flasher/flasher.min.css'], $decoded['styles']);
    }

    public function testFullPipelineAppliesPublicPathFromAssetManagerToRenderedOutput(): void
    {
        // End-to-end: AssetManager → ResourceManager → Response → HtmlPresenter.
        // This is the #298 scenario: app mounted at /Symfony, flasher.min.js must resolve there.
        $assetManager = new AssetManager(
            __DIR__.'/../../Fixtures/Asset',
            __DIR__.'/../../Fixtures/Asset/non-existent-manifest.json',
            '/Symfony',
        );

        $templateEngine = $this->createMock(TemplateEngineInterface::class);
        $resourceManager = new ResourceManager($templateEngine, $assetManager, '/vendor/flasher/flasher.min.js', [
            'flasher' => [
                'scripts' => [],
                'styles' => ['/vendor/flasher/flasher.min.css'],
                'options' => [],
            ],
        ]);

        $response = new Response([new Envelope(new Notification(), [new PluginStamp('flasher')])], []);
        $response = $resourceManager->populateResponse($response);

        $result = (new HtmlPresenter())->render($response);

        $this->assertStringContainsString(
            'const mainScript = "\/Symfony\/vendor\/flasher\/flasher.min.js";',
            $result,
        );
        $this->assertStringContainsString('"\/Symfony\/vendor\/flasher\/flasher.min.css"', $result);
        // Also confirm the old un-prefixed form is NOT present anywhere in the output.
        $this->assertStringNotContainsString('"\/vendor\/flasher\/flasher.min.js"', $result);
    }

    public function testFullPipelineLeavesRenderedOutputUnchangedWhenPublicPathIsEmpty(): void
    {
        // Backwards-compat regression guard: document-root deployments must see the
        // same output as before the patch (no prefix, no mutation).
        $assetManager = new AssetManager(
            __DIR__.'/../../Fixtures/Asset',
            __DIR__.'/../../Fixtures/Asset/non-existent-manifest.json',
            '',
        );

        $templateEngine = $this->createMock(TemplateEngineInterface::class);
        $resourceManager = new ResourceManager($templateEngine, $assetManager, '/vendor/flasher/flasher.min.js', [
            'flasher' => [
                'scripts' => [],
                'styles' => ['/vendor/flasher/flasher.min.css'],
                'options' => [],
            ],
        ]);

        $response = new Response([new Envelope(new Notification(), [new PluginStamp('flasher')])], []);
        $response = $resourceManager->populateResponse($response);

        $result = (new HtmlPresenter())->render($response);

        $this->assertStringContainsString(
            'const mainScript = "\/vendor\/flasher\/flasher.min.js";',
            $result,
        );
        $this->assertStringContainsString('"\/vendor\/flasher\/flasher.min.css"', $result);
        $this->assertStringNotContainsString('/Symfony/', $result);
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
                document.querySelectorAll('.fl-wrapper').forEach(el => el.remove());
            });
        JAVASCRIPT;
    }
}
