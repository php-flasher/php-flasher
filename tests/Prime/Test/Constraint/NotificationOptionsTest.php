<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\Constraint\NotificationOptions;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationOptionsTest extends TestCase
{
    private NotificationOptions $constraint;

    protected function setUp(): void
    {
        $this->constraint = new NotificationOptions(['timeout' => 5000, 'position' => 'top']);
    }

    public function testItIsInstanceOfConstraint(): void
    {
        $this->assertInstanceOf(Constraint::class, $this->constraint);
    }

    public function testToString(): void
    {
        $result = $this->constraint->toString();

        $this->assertStringContainsString('contains a notification with options matching', $result);
        $this->assertStringContainsString('timeout', $result);
        $this->assertStringContainsString('position', $result);
    }

    public function testMatchesWithAllOptionsMatching(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000, 'position' => 'top', 'theme' => 'dark']);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithExactOptionsMatching(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000, 'position' => 'top']);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithPartialOptionsNotMatching(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 5000]);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithDifferentOptionValue(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 3000, 'position' => 'top']);

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
        $notification1->setOptions(['timeout' => 3000]);

        $notification2 = new Notification();
        $notification2->setOptions(['timeout' => 5000, 'position' => 'top']);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification1));
        $events->addEnvelope(new Envelope($notification2));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }
}
