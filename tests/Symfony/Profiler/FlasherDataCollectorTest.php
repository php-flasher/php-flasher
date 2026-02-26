<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Profiler;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Symfony\Profiler\FlasherDataCollector;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\Cloner\Data;

final class FlasherDataCollectorTest extends TestCase
{
    private NotificationLoggerListener $logger;

    private array $config;

    private FlasherDataCollector $collector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = new NotificationLoggerListener();
        $this->config = [
            'default' => 'flasher',
            'main_script' => '/flasher.js',
            'inject_assets' => true,
            'excluded_paths' => [],
            'presets' => ['created' => ['type' => 'success']],
            'flash_bag' => ['success' => ['success']],
            'filter' => ['limit' => 5],
            'plugins' => [['name' => 'toastr']],
        ];

        $this->collector = new FlasherDataCollector($this->logger, $this->config);
    }

    public function testGetName(): void
    {
        $this->assertSame('flasher', $this->collector->getName());
    }

    public function testGetTemplate(): void
    {
        $this->assertSame('@FlasherSymfony/profiler/flasher.html.twig', FlasherDataCollector::getTemplate());
    }

    public function testCollectDoesNothing(): void
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $this->collector->collect($request, $response);

        $this->addToAssertionCount(1);
    }

    public function testLateCollectWithNoEnvelopes(): void
    {
        $this->collector->lateCollect();

        $data = $this->collector->getData();

        $this->assertInstanceOf(Data::class, $data);
        $this->assertArrayHasKey('displayed_envelopes', $data->getValue());
        $this->assertArrayHasKey('dispatched_envelopes', $data->getValue());
        $this->assertArrayHasKey('config', $data->getValue());
        $this->assertArrayHasKey('versions', $data->getValue());
    }

    public function testGetDisplayedEnvelopesBeforeLateCollect(): void
    {
        $envelopes = $this->collector->getDisplayedEnvelopes();

        $this->assertIsArray($envelopes);
        $this->assertEmpty($envelopes);
    }

    public function testGetDispatchedEnvelopesBeforeLateCollect(): void
    {
        $envelopes = $this->collector->getDispatchedEnvelopes();

        $this->assertIsArray($envelopes);
        $this->assertEmpty($envelopes);
    }

    public function testGetConfigBeforeLateCollect(): void
    {
        $config = $this->collector->getConfig();

        $this->assertIsArray($config);
        $this->assertEmpty($config);
    }

    public function testGetVersionsBeforeLateCollect(): void
    {
        $versions = $this->collector->getVersions();

        $this->assertIsArray($versions);
        $this->assertEmpty($versions);
    }

    public function testGetDisplayedEnvelopesAfterLateCollect(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setMessage('Test message');

        $envelope = new Envelope($notification);

        $presentationEvent = new PresentationEvent([$envelope], []);
        $this->logger->onPresentation($presentationEvent);

        $this->collector->lateCollect();

        $envelopes = $this->collector->getDisplayedEnvelopes();

        $this->assertInstanceOf(Data::class, $envelopes);

        $rawData = $this->collector->getData()->getValue();
        $this->assertCount(1, $rawData['displayed_envelopes']);
        $this->assertSame('success', $rawData['displayed_envelopes'][0]['type']);
        $this->assertSame('Test message', $rawData['displayed_envelopes'][0]['message']);
    }

    public function testGetDispatchedEnvelopesAfterLateCollect(): void
    {
        $notification = new Notification();
        $notification->setType('error');
        $notification->setMessage('Error message');

        $envelope = new Envelope($notification);
        $persistEvent = new PersistEvent([$envelope]);
        $this->logger->onPersist($persistEvent);

        $this->collector->lateCollect();

        $envelopes = $this->collector->getDispatchedEnvelopes();

        $this->assertInstanceOf(Data::class, $envelopes);

        $rawData = $this->collector->getData()->getValue();
        $this->assertCount(1, $rawData['dispatched_envelopes']);
        $this->assertSame('error', $rawData['dispatched_envelopes'][0]['type']);
        $this->assertSame('Error message', $rawData['dispatched_envelopes'][0]['message']);
    }

    public function testGetConfigAfterLateCollect(): void
    {
        $this->collector->lateCollect();

        $config = $this->collector->getConfig();

        $this->assertInstanceOf(Data::class, $config);

        $rawData = $this->collector->getData()->getValue();
        $this->assertSame($this->config['default'], $rawData['config']['default']);
        $this->assertSame($this->config['main_script'], $rawData['config']['main_script']);
        $this->assertSame($this->config['inject_assets'], $rawData['config']['inject_assets']);
    }

    public function testGetVersionsAfterLateCollect(): void
    {
        $this->collector->lateCollect();

        $versions = $this->collector->getVersions();

        $this->assertInstanceOf(Data::class, $versions);

        $rawData = $this->collector->getData()->getValue();
        $this->assertArrayHasKey('php_flasher', $rawData['versions']);
        $this->assertArrayHasKey('php', $rawData['versions']);
        $this->assertArrayHasKey('symfony', $rawData['versions']);
        $this->assertSame(\PHP_VERSION, $rawData['versions']['php']);
    }

    public function testReset(): void
    {
        $notification = new Notification();
        $notification->setType('info');
        $notification->setMessage('Info message');

        $envelope = new Envelope($notification);
        $persistEvent = new PersistEvent([$envelope]);
        $this->logger->onPersist($persistEvent);

        $this->collector->reset();

        $this->collector->lateCollect();

        $rawData = $this->collector->getData()->getValue();
        $this->assertEmpty($rawData['dispatched_envelopes']);
    }

    public function testGetDataAfterLateCollect(): void
    {
        $notification = new Notification();
        $notification->setType('info');
        $notification->setMessage('Info message');

        $envelope = new Envelope($notification);
        $presentationEvent = new PresentationEvent([$envelope], []);
        $this->logger->onPresentation($presentationEvent);

        $this->collector->lateCollect();

        $data = $this->collector->getData();

        $this->assertInstanceOf(Data::class, $data);
        $this->assertArrayHasKey('displayed_envelopes', $data->getValue());
        $this->assertArrayHasKey('dispatched_envelopes', $data->getValue());
        $this->assertArrayHasKey('config', $data->getValue());
        $this->assertArrayHasKey('versions', $data->getValue());
    }

    public function testMultipleNotificationsInEnvelopes(): void
    {
        $notification1 = new Notification();
        $notification1->setType('success');
        $notification1->setMessage('Success 1');

        $notification2 = new Notification();
        $notification2->setType('warning');
        $notification2->setMessage('Warning 1');

        $notification3 = new Notification();
        $notification3->setType('error');
        $notification3->setMessage('Error 1');

        $envelope1 = new Envelope($notification1);
        $envelope2 = new Envelope($notification2);
        $envelope3 = new Envelope($notification3);

        $presentationEvent = new PresentationEvent([$envelope1, $envelope2], []);
        $this->logger->onPresentation($presentationEvent);

        $persistEvent = new PersistEvent([$envelope1, $envelope2, $envelope3]);
        $this->logger->onPersist($persistEvent);

        $this->collector->lateCollect();

        $displayed = $this->collector->getDisplayedEnvelopes();
        $dispatched = $this->collector->getDispatchedEnvelopes();

        $this->assertInstanceOf(Data::class, $displayed);
        $this->assertInstanceOf(Data::class, $dispatched);

        $rawData = $this->collector->getData()->getValue();
        $this->assertCount(2, $rawData['displayed_envelopes']);
        $this->assertCount(3, $rawData['dispatched_envelopes']);
    }

    public function testNotificationWithAllProperties(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setMessage('Test message');
        $notification->setTitle('Test Title');
        $notification->setOptions(['timeout' => 5000, 'position' => 'top']);

        $envelope = new Envelope($notification);
        $presentationEvent = new PresentationEvent([$envelope], []);
        $this->logger->onPresentation($presentationEvent);

        $this->collector->lateCollect();

        $displayed = $this->collector->getDisplayedEnvelopes();

        $this->assertInstanceOf(Data::class, $displayed);

        $rawData = $this->collector->getData()->getValue();
        $this->assertCount(1, $rawData['displayed_envelopes']);
        $this->assertSame('success', $rawData['displayed_envelopes'][0]['type']);
        $this->assertSame('Test message', $rawData['displayed_envelopes'][0]['message']);
        $this->assertSame('Test Title', $rawData['displayed_envelopes'][0]['title']);

        $options = $rawData['displayed_envelopes'][0]['options'];
        $this->assertInstanceOf(Data::class, $options);
        $this->assertSame(['timeout', 'position'], array_keys($options->getValue()));
    }

    public function testCollectWithException(): void
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $exception = new \RuntimeException('Test exception');

        $this->collector->collect($request, $response, $exception);

        $this->addToAssertionCount(1);
    }

    public function testEmptyConfig(): void
    {
        $collector = new FlasherDataCollector($this->logger, []);

        $collector->lateCollect();

        $config = $collector->getConfig();

        $this->assertInstanceOf(Data::class, $config);

        $rawData = $collector->getData()->getValue();
        $this->assertEmpty($rawData['config']);
    }

    public function testVersionsContainPhpFlasherVersion(): void
    {
        $this->collector->lateCollect();

        $rawData = $this->collector->getData()->getValue();

        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+/', $rawData['versions']['php_flasher']);
    }

    public function testVersionsContainSymfonyVersion(): void
    {
        $this->collector->lateCollect();

        $rawData = $this->collector->getData()->getValue();

        $this->assertMatchesRegularExpression('/^\d+\.\d+/', $rawData['versions']['symfony']);
    }
}
