<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\Constraint\NotificationMessage;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationMessageTest extends TestCase
{
    private NotificationMessage $constraint;

    protected function setUp(): void
    {
        $this->constraint = new NotificationMessage('Test message');
    }

    public function testItIsInstanceOfConstraint(): void
    {
        $this->assertInstanceOf(Constraint::class, $this->constraint);
    }

    public function testToString(): void
    {
        $this->assertSame('contains a notification with message "Test message"', $this->constraint->toString());
    }

    public function testMatchesWithExactMessage(): void
    {
        $notification = new Notification();
        $notification->setMessage('Test message');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithPartialMessage(): void
    {
        $notification = new Notification();
        $notification->setMessage('This is a Test message for you');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithMessageNotPresent(): void
    {
        $notification = new Notification();
        $notification->setMessage('Different message');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithEmptyEvents(): void
    {
        $events = new NotificationEvents();

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithNonNotificationEvents(): void
    {
        $result = $this->constraint->evaluate('not an event', '', true);

        $this->assertFalse($result);
    }
}
