<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

final readonly class AddToStorageListener implements EventListenerInterface
{
    public function __invoke(PersistEvent $event): void
    {
        $envelopes = array_filter($event->getEnvelopes(), $this->isEligibleForStorage(...));

        $event->setEnvelopes($envelopes);
    }

    public function getSubscribedEvents(): string
    {
        return PersistEvent::class;
    }

    private function isEligibleForStorage(Envelope $envelope): bool
    {
        return $this->whenCondition($envelope) && $this->unlessCondition($envelope);
    }

    private function whenCondition(Envelope $envelope): bool
    {
        $whenStamp = $envelope->get(WhenStamp::class);

        return !($whenStamp instanceof WhenStamp && !$whenStamp->getCondition());
    }

    private function unlessCondition(Envelope $envelope): bool
    {
        $unlessStamp = $envelope->get(UnlessStamp::class);

        return !($unlessStamp instanceof UnlessStamp && $unlessStamp->getCondition());
    }
}
