<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\Constraint\NotificationOption;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationOptionTest extends TestCase
{
    public function testItIsInstanceOfConstraint(): void
    {
        $constraint = new NotificationOption('timeout');
        $this->assertInstanceOf(Constraint::class, $constraint);
    }

    public function testToStringWithoutValue(): void
    {
        $constraint = new NotificationOption('timeout');

        $this->assertSame('contains a notification with an option "timeout"', $constraint->toString());
    }

    public function testToStringWithValue(): void
    {
        $constraint = new NotificationOption('timeout', 5000);

        $this->assertStringContainsString('contains a notification with an option "timeout"', $constraint->toString());
        $this->assertStringContainsString('5000', $constraint->toString());
    }

    public function testMatchesWithMatchingOption(): void
    {
        $constraint = new NotificationOption('timeout', 5000);

        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000, 'position' => 'top']);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithNonMatchingValue(): void
    {
        $constraint = new NotificationOption('timeout', 5000);

        $notification = new Notification();
        $notification->setOptions(['timeout' => 3000]);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithMissingOption(): void
    {
        $constraint = new NotificationOption('timeout', 5000);

        $notification = new Notification();
        $notification->setOptions(['position' => 'top']);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithEmptyEvents(): void
    {
        $constraint = new NotificationOption('timeout', 5000);
        $events = new NotificationEvents();

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithNonNotificationEvents(): void
    {
        $constraint = new NotificationOption('timeout', 5000);

        $result = $constraint->evaluate('not an event', '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithMultipleNotifications(): void
    {
        $constraint = new NotificationOption('timeout', 5000);

        $notification1 = new Notification();
        $notification1->setOptions(['timeout' => 3000]);

        $notification2 = new Notification();
        $notification2->setOptions(['timeout' => 5000]);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification1));
        $events->addEnvelope(new Envelope($notification2));

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }
}
