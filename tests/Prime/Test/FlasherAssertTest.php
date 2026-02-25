<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\FlasherAssert;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class FlasherAssertTest extends TestCase
{
    private NotificationLoggerListener $listener;

    protected function setUp(): void
    {
        parent::setUp();
        FlasherContainer::reset();

        $this->listener = new NotificationLoggerListener();

        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')
            ->with('flasher.notification_logger_listener')
            ->willReturn(true);
        $container->method('get')
            ->with('flasher.notification_logger_listener')
            ->willReturn($this->listener);

        FlasherContainer::from($container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        FlasherContainer::reset();
    }

    private function addNotification(Notification $notification): void
    {
        $envelope = new Envelope($notification);
        $event = new PresentationEvent([$envelope], []);
        $this->listener->onPresentation($event);
    }

    public function testThatReturnsSelf(): void
    {
        $result = FlasherAssert::that();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testHasNotificationsPasses(): void
    {
        $this->addNotification(new Notification());

        $result = FlasherAssert::hasNotifications();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testHasNotificationsFails(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Expected at least one notification to exist.');

        FlasherAssert::hasNotifications();
    }

    public function testNoNotificationsPasses(): void
    {
        $result = FlasherAssert::noNotifications();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testNoNotificationsFails(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Expected no notifications to exist.');

        $this->addNotification(new Notification());

        FlasherAssert::noNotifications();
    }

    public function testWithNotificationPasses(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setMessage('Test message');

        $this->addNotification($notification);

        $result = FlasherAssert::withNotification('success', 'Test message');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithNotificationFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $notification = new Notification();
        $notification->setType('error');

        $this->addNotification($notification);

        FlasherAssert::withNotification('success');
    }

    public function testNotificationAlias(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setMessage('Test message');

        $this->addNotification($notification);

        $result = FlasherAssert::notification('success', 'Test message');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithCountPasses(): void
    {
        $this->addNotification(new Notification());
        $this->addNotification(new Notification());

        $result = FlasherAssert::withCount(2);

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithCountFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->addNotification(new Notification());

        FlasherAssert::withCount(2);
    }

    public function testCountAlias(): void
    {
        $this->addNotification(new Notification());
        $this->addNotification(new Notification());

        $result = FlasherAssert::count(2);

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithTypePasses(): void
    {
        $notification = new Notification();
        $notification->setType('success');

        $this->addNotification($notification);

        $result = FlasherAssert::withType('success');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithTypeFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $notification = new Notification();
        $notification->setType('error');

        $this->addNotification($notification);

        FlasherAssert::withType('success');
    }

    public function testTypeAlias(): void
    {
        $notification = new Notification();
        $notification->setType('success');

        $this->addNotification($notification);

        $result = FlasherAssert::type('success');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithSuccessPasses(): void
    {
        $notification = new Notification();
        $notification->setType('success');

        $this->addNotification($notification);

        $result = FlasherAssert::withSuccess();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testSuccessAlias(): void
    {
        $notification = new Notification();
        $notification->setType('success');

        $this->addNotification($notification);

        $result = FlasherAssert::success();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithWarningPasses(): void
    {
        $notification = new Notification();
        $notification->setType('warning');

        $this->addNotification($notification);

        $result = FlasherAssert::withWarning();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWarningAlias(): void
    {
        $notification = new Notification();
        $notification->setType('warning');

        $this->addNotification($notification);

        $result = FlasherAssert::warning();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithErrorPasses(): void
    {
        $notification = new Notification();
        $notification->setType('error');

        $this->addNotification($notification);

        $result = FlasherAssert::withError();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testErrorAlias(): void
    {
        $notification = new Notification();
        $notification->setType('error');

        $this->addNotification($notification);

        $result = FlasherAssert::error();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithInfoPasses(): void
    {
        $notification = new Notification();
        $notification->setType('info');

        $this->addNotification($notification);

        $result = FlasherAssert::withInfo();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testInfoAlias(): void
    {
        $notification = new Notification();
        $notification->setType('info');

        $this->addNotification($notification);

        $result = FlasherAssert::info();

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithTitlePasses(): void
    {
        $notification = new Notification();
        $notification->setTitle('Test Title');

        $this->addNotification($notification);

        $result = FlasherAssert::withTitle('Test Title');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithTitleFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $notification = new Notification();
        $notification->setTitle('Different Title');

        $this->addNotification($notification);

        FlasherAssert::withTitle('Test Title');
    }

    public function testTitleAlias(): void
    {
        $notification = new Notification();
        $notification->setTitle('Test Title');

        $this->addNotification($notification);

        $result = FlasherAssert::title('Test Title');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithMessagePasses(): void
    {
        $notification = new Notification();
        $notification->setMessage('Test message');

        $this->addNotification($notification);

        $result = FlasherAssert::withMessage('Test message');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithMessageFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $notification = new Notification();
        $notification->setMessage('Different message');

        $this->addNotification($notification);

        FlasherAssert::withMessage('Test message');
    }

    public function testMessageAlias(): void
    {
        $notification = new Notification();
        $notification->setMessage('Test message');

        $this->addNotification($notification);

        $result = FlasherAssert::message('Test message');

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithOptionsPasses(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000, 'position' => 'top']);

        $this->addNotification($notification);

        $result = FlasherAssert::withOptions(['timeout' => 5000]);

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithOptionsFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $notification = new Notification();
        $notification->setOptions(['timeout' => 3000]);

        $this->addNotification($notification);

        FlasherAssert::withOptions(['timeout' => 5000]);
    }

    public function testOptionsAlias(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000]);

        $this->addNotification($notification);

        $result = FlasherAssert::options(['timeout' => 5000]);

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithOptionPasses(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000]);

        $this->addNotification($notification);

        $result = FlasherAssert::withOption('timeout', 5000);

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testWithOptionFails(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $notification = new Notification();
        $notification->setOptions(['timeout' => 3000]);

        $this->addNotification($notification);

        FlasherAssert::withOption('timeout', 5000);
    }

    public function testOptionAlias(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000]);

        $this->addNotification($notification);

        $result = FlasherAssert::option('timeout', 5000);

        $this->assertInstanceOf(FlasherAssert::class, $result);
    }

    public function testGetNotificationEventsWithoutListener(): void
    {
        FlasherContainer::reset();

        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')->willReturn(false);
        FlasherContainer::from($container);

        $events = FlasherAssert::getNotificationEvents();

        $this->assertInstanceOf(NotificationEvents::class, $events);
        $this->assertCount(0, $events->getEnvelopes());
    }

    public function testChainedAssertions(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setMessage('Test message');
        $notification->setTitle('Test Title');
        $notification->setOptions(['timeout' => 5000]);

        $this->addNotification($notification);

        FlasherAssert::hasNotifications()
            ->count(1)
            ->type('success')
            ->message('Test message')
            ->title('Test Title')
            ->option('timeout', 5000);
    }
}
