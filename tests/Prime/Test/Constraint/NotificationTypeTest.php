<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\Constraint\NotificationType;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationTypeTest extends TestCase
{
    private NotificationType $constraint;

    protected function setUp(): void
    {
        $this->constraint = new NotificationType('success');
    }

    public function testItIsInstanceOfConstraint(): void
    {
        $this->assertInstanceOf(Constraint::class, $this->constraint);
    }

    public function testToString(): void
    {
        $this->assertSame('contains a notification of type "success".', $this->constraint->toString());
    }

    public function testMatchesWithTypePresent(): void
    {
        $notification = new Notification();
        $notification->setType('success');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithTypeNotPresent(): void
    {
        $notification = new Notification();
        $notification->setType('error');

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

    public function testMatchesWithMultipleNotifications(): void
    {
        $notification1 = new Notification();
        $notification1->setType('error');

        $notification2 = new Notification();
        $notification2->setType('success');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification1));
        $events->addEnvelope(new Envelope($notification2));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }
}
