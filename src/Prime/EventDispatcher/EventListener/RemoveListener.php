<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Stamp\HopsStamp;

final class RemoveListener implements EventSubscriberInterface
{
    public function __invoke(RemoveEvent $event)
    {
        $envelopesToKeep = $event->getEnvelopesToKeep();
        $envelopesToRemove = array();

        foreach ($event->getEnvelopesToRemove() as $envelope) {
            $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

            if (1 === $hopsStamp->getAmount()) {
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
