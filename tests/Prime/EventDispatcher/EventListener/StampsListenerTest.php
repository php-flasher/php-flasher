<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\AttachDefaultStampsListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Tests\Prime\Helper\ObjectInvader;
use PHPUnit\Framework\TestCase;

final class StampsListenerTest extends TestCase
{
    public function testStampsListener(): void
    {
        $eventDispatcher = new EventDispatcher();
        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new AttachDefaultStampsListener();
        $eventDispatcher->addListener($listener);

        $envelopes = [
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $envelopes = $event->getEnvelopes();

        $this->assertInstanceOf(CreatedAtStamp::class, $envelopes[0]->get(CreatedAtStamp::class));
        $this->assertInstanceOf(IdStamp::class, $envelopes[0]->get(IdStamp::class));
        $this->assertInstanceOf(DelayStamp::class, $envelopes[0]->get(DelayStamp::class));
        $this->assertInstanceOf(HopsStamp::class, $envelopes[0]->get(HopsStamp::class));
        $this->assertInstanceOf(PriorityStamp::class, $envelopes[0]->get(PriorityStamp::class));
    }
}
