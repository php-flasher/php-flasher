<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Stamp\HopsStamp;

final class RemoveListener implements EventSubscriberInterface
{
    /**
     * @return void
     */
    public function __invoke(RemoveEvent $event)
    {
        $envelopesToKeep = $event->getEnvelopesToKeep();
        $envelopesToRemove = [];

        foreach ($event->getEnvelopesToRemove() as $envelope) {
            $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
            if (!$hopsStamp instanceof HopsStamp || 1 === $hopsStamp->getAmount()) {
                $envelopesToRemove[] = $envelope;

                continue;
            }

            $envelope->with(new HopsStamp($hopsStamp->getAmount() - 1));
            $envelopesToKeep[] = $envelope;
        }

        $event->setEnvelopesToKeep($envelopesToKeep);
        $event->setEnvelopesToRemove($envelopesToRemove);
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\RemoveEvent';
    }
}
