<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\Constraint\NotificationTitle;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationTitleTest extends TestCase
{
    private NotificationTitle $constraint;

    protected function setUp(): void
    {
        $this->constraint = new NotificationTitle('Test Title');
    }

    public function testItIsInstanceOfConstraint(): void
    {
        $this->assertInstanceOf(Constraint::class, $this->constraint);
    }

    public function testToString(): void
    {
        $this->assertSame('contains a notification with a title containing "Test Title"', $this->constraint->toString());
    }

    public function testMatchesWithExactTitle(): void
    {
        $notification = new Notification();
        $notification->setTitle('Test Title');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithPartialTitle(): void
    {
        $notification = new Notification();
        $notification->setTitle('This is a Test Title for you');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithTitleNotPresent(): void
    {
        $notification = new Notification();
        $notification->setTitle('Different Title');

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
