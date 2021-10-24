<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;

final class StampsListener implements EventSubscriberInterface
{
    /**
     * @param PersistEvent|UpdateEvent $event
     *
     * @return void
     */
    public function __invoke($event)
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachStamps($envelope);
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Flasher\Prime\EventDispatcher\Event\PersistEvent',
            'Flasher\Prime\EventDispatcher\Event\UpdateEvent',
        );
    }

    /**
     * @return void
     */
    private function attachStamps(Envelope $envelope)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\CreatedAtStamp')) {
            $envelope->withStamp(new CreatedAtStamp());
        }

        if (null === $envelope->get('Flasher\Prime\Stamp\UuidStamp')) {
            $envelope->withStamp(new UuidStamp());
        }

        if (null === $envelope->get('Flasher\Prime\Stamp\DelayStamp')) {
            $envelope->withStamp(new DelayStamp(0));
        }

        if (null === $envelope->get('Flasher\Prime\Stamp\HopsStamp')) {
            $envelope->withStamp(new HopsStamp(1));
        }

        if (null === $envelope->get('Flasher\Prime\Stamp\PriorityStamp')) {
            $envelope->withStamp(new PriorityStamp(0));
        }
    }
}
