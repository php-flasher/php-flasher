<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
        $envelopesToRemove = array();

        foreach ($event->getEnvelopesToRemove() as $envelope) {
            $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
            if (!$hopsStamp instanceof HopsStamp) {
                continue;
            }

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

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\RemoveEvent';
    }
}
