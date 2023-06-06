<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

final class AddToStorageListener implements EventSubscriberInterface
{
    /**
     * @return void
     */
    public function __invoke(PersistEvent $event)
    {
        $envelopesToKeep = [];

        foreach ($event->getEnvelopes() as $envelope) {
            if ($this->shouldKeep($envelope)) {
                $envelopesToKeep[] = $envelope;
            }
        }

        $event->setEnvelopes($envelopesToKeep);
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PersistEvent';
    }

    /**
     * @return bool
     */
    private function shouldKeep(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\WhenStamp');
        if ($stamp instanceof WhenStamp && false === $stamp->getCondition()) {
            return false;
        }

        $stamp = $envelope->get('Flasher\Prime\Stamp\UnlessStamp');
        if ($stamp instanceof UnlessStamp && true === $stamp->getCondition()) {
            return false;
        }

        return true;
    }
}
