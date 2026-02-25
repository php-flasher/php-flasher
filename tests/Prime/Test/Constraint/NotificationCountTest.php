<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Test\Constraint\NotificationCount;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationCountTest extends TestCase
{
    private NotificationCount $constraint;

    protected function setUp(): void
    {
        $this->constraint = new NotificationCount(2);
    }

    public function testItIsInstanceOfConstraint(): void
    {
        $this->assertInstanceOf(Constraint::class, $this->constraint);
    }

    public function testToString(): void
    {
        $this->assertSame('matches the expected notification count of 2.', $this->constraint->toString());
    }

    public function testMatchesWithCorrectCount(): void
    {
        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope(new Notification()));
        $events->addEnvelope(new Envelope(new Notification()));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithIncorrectCount(): void
    {
        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope(new Notification()));

        $result = $this->constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithEmptyEvents(): void
    {
        $constraint = new NotificationCount(0);
        $events = new NotificationEvents();

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithNonNotificationEvents(): void
    {
        $result = $this->constraint->evaluate('not an event', '', true);

        $this->assertFalse($result);
    }
}
