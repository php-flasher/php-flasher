<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Stamp\HopsStamp;

final class RemoveListener implements EventListenerInterface
{
    public function __invoke(RemoveEvent $event): void
    {
        $envelopesToKeep = $event->getEnvelopesToKeep();
        $envelopesToRemove = [];

        foreach ($event->getEnvelopesToRemove() as $envelope) {
            $hopsStamp = $envelope->get(HopsStamp::class);
            if (! $hopsStamp instanceof HopsStamp || 1 === $hopsStamp->getAmount()) {
                $envelopesToRemove[] = $envelope;

                continue;
            }

            $envelope->withStamp(new HopsStamp($hopsStamp->getAmount() - 1));
            $envelopesToKeep[] = $envelope;
        }

        $event->setEnvelopesToKeep($envelopesToKeep);
        $event->setEnvelopesToRemove($envelopesToRemove);
    }

    public static function getSubscribedEvents(): string
    {
        return RemoveEvent::class;
    }
}
