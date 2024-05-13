<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PriorityStamp;

/**
 * Listener responsible for attaching default stamps to envelopes during persist and update events.
 */
final readonly class AttachDefaultStampsListener implements EventListenerInterface
{
    public function __invoke(PersistEvent|UpdateEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachStamps($envelope);
        }
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            PersistEvent::class,
            UpdateEvent::class,
        ];
    }

    private function attachStamps(Envelope $envelope): void
    {
        $envelope->withStamp(new CreatedAtStamp(), false);
        $envelope->withStamp(new IdStamp(), false);
        $envelope->withStamp(new DelayStamp(0), false);
        $envelope->withStamp(new HopsStamp(1), false);
        $envelope->withStamp(new PriorityStamp(0), false);
    }
}
