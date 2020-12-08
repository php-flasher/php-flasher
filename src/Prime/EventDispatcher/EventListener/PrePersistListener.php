<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PrePersistEvent;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;

final class PrePersistListener implements EventSubscriberInterface
{
    /**
     * @param PrePersistEvent $event
     */
    public function __invoke(PrePersistEvent $event)
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachStamps($envelope);
        }
    }

    /**
     * @param Envelope $envelope
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

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PrePersistEvent';
    }
}
