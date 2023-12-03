<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\AttachDefaultStampsListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

final class StampsListenerTest extends TestCase
{
    public function testStampsListener(): void
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', []);

        $listener = new AttachDefaultStampsListener();
        $eventDispatcher->addSubscriber($listener);

        $envelopes = [
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $envelopes = $event->getEnvelopes();

        $this->assertInstanceOf(\Flasher\Prime\Stamp\CreatedAtStamp::class, $envelopes[0]->get(\Flasher\Prime\Stamp\CreatedAtStamp::class));
        $this->assertInstanceOf(\Flasher\Prime\Stamp\IdStamp::class, $envelopes[0]->get(\Flasher\Prime\Stamp\IdStamp::class));
        $this->assertInstanceOf(\Flasher\Prime\Stamp\DelayStamp::class, $envelopes[0]->get(\Flasher\Prime\Stamp\DelayStamp::class));
        $this->assertInstanceOf(\Flasher\Prime\Stamp\HopsStamp::class, $envelopes[0]->get(\Flasher\Prime\Stamp\HopsStamp::class));
        $this->assertInstanceOf(\Flasher\Prime\Stamp\PriorityStamp::class, $envelopes[0]->get(\Flasher\Prime\Stamp\PriorityStamp::class));
    }
}
