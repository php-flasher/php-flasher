<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response\Resource;

use Flasher\Prime\Asset\AssetManagerInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\HtmlStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Template\TemplateEngineInterface;
use PHPUnit\Framework\TestCase;

final class ResourceManagerTest extends TestCase
{
    public function testItPopulateResponseFromResources(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, 'main_script.min.js', [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
                'styles' => ['flasher.min.css'],
                'options' => ['timeout' => 2500, 'position' => 'center'],
            ],
            'toastr' => [
                'scripts' => ['toastr.min.js', 'jquery.min.js'],
                'styles' => ['toastr.min.css'],
                'options' => ['sounds' => false],
            ],
        ]);

        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, [
            new PluginStamp('flasher'),
            new CreatedAtStamp(new \DateTimeImmutable('2023-02-05 16:22:50')),
            new IdStamp('1111'),
        ]);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, [
            new PluginStamp('toastr'),
            new CreatedAtStamp(new \DateTimeImmutable('2023-02-05 16:22:50')),
            new IdStamp('2222'),
        ]);

        $response = new Response($envelopes, []);

        $response = $resourceManager->populateResponse($response);

        $this->assertEquals($envelopes, $response->getEnvelopes());
        $this->assertSame('main_script.min.js', $response->getMainScript());
        $this->assertSame(['flasher.min.js', 'toastr.min.js', 'jquery.min.js'], $response->getScripts());
        $this->assertSame(['flasher.min.css', 'toastr.min.css'], $response->getStyles());
        $this->assertEquals([
            'toastr' => ['sounds' => false],
            'flasher' => ['timeout' => 2500, 'position' => 'center'],
        ], $response->getOptions());
    }

    public function testPopulateResponseWithoutMainScript(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
                'styles' => ['flasher.min.css'],
            ],
        ]);

        $notification = new Notification();
        $notification->setMessage('Test message');
        $envelope = new Envelope($notification, [new PluginStamp('flasher')]);

        $response = new Response([$envelope], []);
        $response = $resourceManager->populateResponse($response);

        // Main script defaults to empty string when not set
        $this->assertSame('', $response->getMainScript());
        $this->assertSame(['flasher.min.js'], $response->getScripts());
    }

    public function testPopulateResponseWithEnvelopeWithoutPluginStamp(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, []);

        $notification = new Notification();
        $notification->setMessage('Test message');
        $envelope = new Envelope($notification);

        $response = new Response([$envelope], []);
        $response = $resourceManager->populateResponse($response);

        $this->assertSame([], $response->getScripts());
        $this->assertSame([], $response->getStyles());
    }

    public function testPopulateResponseWithThemePluginFallback(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
                'styles' => ['flasher.min.css'],
                'options' => ['timeout' => 3000],
            ],
        ]);

        $notification = new Notification();
        $notification->setMessage('Theme message');
        $envelope = new Envelope($notification, [new PluginStamp('theme.custom')]);

        $response = new Response([$envelope], []);
        $response = $resourceManager->populateResponse($response);

        // Theme plugin should fallback to flasher resources
        $this->assertSame(['flasher.min.js'], $response->getScripts());
        $this->assertSame(['flasher.min.css'], $response->getStyles());
    }

    public function testPopulateResponseWithViewTemplate(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);
        $templateEngine->expects($this->once())
            ->method('render')
            ->with('@flasher/notification.html.twig', $this->anything())
            ->willReturn('<div class="notification">Test</div>');

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
                'view' => '@flasher/notification.html.twig',
            ],
        ]);

        $notification = new Notification();
        $notification->setMessage('Test message');
        $envelope = new Envelope($notification, [new PluginStamp('flasher')]);

        $response = new Response([$envelope], []);
        $response = $resourceManager->populateResponse($response);

        // Envelope should have HtmlStamp added
        $htmlStamp = $envelope->get(HtmlStamp::class);
        $this->assertInstanceOf(HtmlStamp::class, $htmlStamp);
        $this->assertSame('<div class="notification">Test</div>', $htmlStamp->getHtml());
    }

    public function testPopulateResponseWithDuplicatePlugins(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
                'styles' => ['flasher.min.css'],
            ],
        ]);

        $envelopes = [
            new Envelope(new Notification(), [new PluginStamp('flasher')]),
            new Envelope(new Notification(), [new PluginStamp('flasher')]),
            new Envelope(new Notification(), [new PluginStamp('flasher')]),
        ];

        $response = new Response($envelopes, []);
        $response = $resourceManager->populateResponse($response);

        // Scripts and styles should not be duplicated
        $this->assertSame(['flasher.min.js'], $response->getScripts());
        $this->assertSame(['flasher.min.css'], $response->getStyles());
    }

    public function testPopulateResponseWithEmptyResources(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'flasher' => [],
        ]);

        $notification = new Notification();
        $envelope = new Envelope($notification, [new PluginStamp('flasher')]);

        $response = new Response([$envelope], []);
        $response = $resourceManager->populateResponse($response);

        $this->assertSame([], $response->getScripts());
        $this->assertSame([], $response->getStyles());
    }

    public function testPopulateResponseWithUnknownPlugin(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
            ],
        ]);

        $notification = new Notification();
        $envelope = new Envelope($notification, [new PluginStamp('unknown_plugin')]);

        $response = new Response([$envelope], []);
        $response = $resourceManager->populateResponse($response);

        // Unknown plugin should not cause errors, just empty resources
        $this->assertSame([], $response->getScripts());
    }

    public function testPopulateResponseWithEmptyEnvelopes(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->expects($this->never())->method('getPaths');

        $resourceManager = new ResourceManager($templateEngine, $assetManager, 'main.js', []);

        $response = new Response([], []);
        $response = $resourceManager->populateResponse($response);

        $this->assertSame('main.js', $response->getMainScript());
        $this->assertSame([], $response->getScripts());
    }

    public function testPopulateResponseWithMultiplePlugins(): void
    {
        $templateEngine = $this->createMock(TemplateEngineInterface::class);

        $assetManager = $this->createMock(AssetManagerInterface::class);
        $assetManager->method('getPath')->willReturnArgument(0);
        $assetManager->method('getPaths')->willReturnArgument(0);

        $resourceManager = new ResourceManager($templateEngine, $assetManager, null, [
            'toastr' => [
                'scripts' => ['toastr.js'],
                'styles' => ['toastr.css'],
                'options' => ['progressBar' => true],
            ],
            'noty' => [
                'scripts' => ['noty.js'],
                'styles' => ['noty.css'],
                'options' => ['theme' => 'mint'],
            ],
            'sweetalert' => [
                'scripts' => ['sweetalert.js'],
                'styles' => ['sweetalert.css'],
                'options' => ['confirmButtonColor' => '#3085d6'],
            ],
        ]);

        $envelopes = [
            new Envelope(new Notification(), [new PluginStamp('toastr')]),
            new Envelope(new Notification(), [new PluginStamp('noty')]),
            new Envelope(new Notification(), [new PluginStamp('sweetalert')]),
        ];

        $response = new Response($envelopes, []);
        $response = $resourceManager->populateResponse($response);

        $this->assertSame(['toastr.js', 'noty.js', 'sweetalert.js'], $response->getScripts());
        $this->assertSame(['toastr.css', 'noty.css', 'sweetalert.css'], $response->getStyles());
        $this->assertArrayHasKey('toastr', $response->getOptions());
        $this->assertArrayHasKey('noty', $response->getOptions());
        $this->assertArrayHasKey('sweetalert', $response->getOptions());
    }
}
