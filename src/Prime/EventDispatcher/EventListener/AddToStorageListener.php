<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

final class AddToStorageListener implements EventListenerInterface
{
    public function __invoke(PersistEvent $event): void
    {
        $envelopesToKeep = [];

        foreach ($event->getEnvelopes() as $envelope) {
            if ($this->shouldKeep($envelope)) {
                $envelopesToKeep[] = $envelope;
            }
        }

        $event->setEnvelopes($envelopesToKeep);
    }

    public static function getSubscribedEvents(): string
    {
        return PersistEvent::class;
    }

    private function shouldKeep(Envelope $envelope): bool
    {
        $stamp = $envelope->get(WhenStamp::class);
        if ($stamp instanceof WhenStamp && ! $stamp->getCondition()) {
            return false;
        }

        $stamp = $envelope->get(UnlessStamp::class);

        return ! ($stamp instanceof UnlessStamp && $stamp->getCondition());
    }
}
