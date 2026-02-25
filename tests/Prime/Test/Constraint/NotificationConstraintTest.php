<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification as NotificationEntity;
use Flasher\Prime\Test\Constraint\Notification;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

final class NotificationConstraintTest extends TestCase
{
    public function testItIsInstanceOfConstraint(): void
    {
        $constraint = new Notification('success');
        $this->assertInstanceOf(Constraint::class, $constraint);
    }

    public function testToStringWithTypeOnly(): void
    {
        $constraint = new Notification('success');

        $this->assertStringContainsString('type: "success"', $constraint->toString());
    }

    public function testToStringWithMessage(): void
    {
        $constraint = new Notification('success', 'Test message');

        $result = $constraint->toString();

        $this->assertStringContainsString('type: "success"', $result);
        $this->assertStringContainsString('message: "Test message"', $result);
    }

    public function testToStringWithTitle(): void
    {
        $constraint = new Notification('success', null, [], 'Test Title');

        $result = $constraint->toString();

        $this->assertStringContainsString('type: "success"', $result);
        $this->assertStringContainsString('title: "Test Title"', $result);
    }

    public function testToStringWithOptions(): void
    {
        $constraint = new Notification('success', null, ['timeout' => 5000]);

        $result = $constraint->toString();

        $this->assertStringContainsString('type: "success"', $result);
        $this->assertStringContainsString('timeout', $result);
    }

    public function testMatchesWithMatchingType(): void
    {
        $constraint = new Notification('success');

        $notification = new NotificationEntity();
        $notification->setType('success');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithAllPropertiesMatching(): void
    {
        $constraint = new Notification('success', 'Test message', ['timeout' => 5000], 'Test Title');

        $notification = new NotificationEntity();
        $notification->setType('success');
        $notification->setMessage('Test message');
        $notification->setOptions(['timeout' => 5000, 'position' => 'top']);
        $notification->setTitle('Test Title');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithNonMatchingType(): void
    {
        $constraint = new Notification('success');

        $notification = new NotificationEntity();
        $notification->setType('error');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithNonMatchingMessage(): void
    {
        $constraint = new Notification('success', 'Expected message');

        $notification = new NotificationEntity();
        $notification->setType('success');
        $notification->setMessage('Different message');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithNonMatchingTitle(): void
    {
        $constraint = new Notification('success', null, [], 'Expected Title');

        $notification = new NotificationEntity();
        $notification->setType('success');
        $notification->setTitle('Different Title');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithNonMatchingOptions(): void
    {
        $constraint = new Notification('success', null, ['timeout' => 5000]);

        $notification = new NotificationEntity();
        $notification->setType('success');
        $notification->setOptions(['timeout' => 3000]);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithPartialOptionsMatching(): void
    {
        $constraint = new Notification('success', null, ['timeout' => 5000]);

        $notification = new NotificationEntity();
        $notification->setType('success');
        $notification->setOptions(['timeout' => 5000, 'position' => 'top']);

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification));

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }

    public function testMatchesWithEmptyEvents(): void
    {
        $constraint = new Notification('success');
        $events = new NotificationEvents();

        $result = $constraint->evaluate($events, '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithNonNotificationEvents(): void
    {
        $constraint = new Notification('success');

        $result = $constraint->evaluate('not an event', '', true);

        $this->assertFalse($result);
    }

    public function testMatchesWithMultipleNotifications(): void
    {
        $constraint = new Notification('warning', 'Warning message');

        $notification1 = new NotificationEntity();
        $notification1->setType('success');
        $notification1->setMessage('Success message');

        $notification2 = new NotificationEntity();
        $notification2->setType('warning');
        $notification2->setMessage('Warning message');

        $events = new NotificationEvents();
        $events->addEnvelope(new Envelope($notification1));
        $events->addEnvelope(new Envelope($notification2));

        $result = $constraint->evaluate($events, '', true);

        $this->assertTrue($result);
    }
}
