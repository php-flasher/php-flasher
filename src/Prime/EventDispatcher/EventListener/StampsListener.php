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

final class StampsListener implements EventListenerInterface
{
    public function __invoke(PersistEvent|UpdateEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachStamps($envelope);
        }
    }

    public static function getSubscribedEvents(): string|array
    {
        return [
            PersistEvent::class,
            UpdateEvent::class,
        ];
    }

    private function attachStamps(Envelope $envelope): void
    {
        if (! $envelope->get(CreatedAtStamp::class) instanceof CreatedAtStamp) {
            $envelope->withStamp(new CreatedAtStamp());
        }

        if (! $envelope->get(IdStamp::class) instanceof IdStamp) {
            $envelope->withStamp(new IdStamp(spl_object_hash($envelope)));
        }

        if (! $envelope->get(DelayStamp::class) instanceof DelayStamp) {
            $envelope->withStamp(new DelayStamp(0));
        }

        if (! $envelope->get(HopsStamp::class) instanceof HopsStamp) {
            $envelope->withStamp(new HopsStamp(1));
        }

        if (! $envelope->get(PriorityStamp::class) instanceof PriorityStamp) {
            $envelope->withStamp(new PriorityStamp(0));
        }
    }
}
