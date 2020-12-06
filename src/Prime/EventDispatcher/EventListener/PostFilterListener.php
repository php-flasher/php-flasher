<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PostFilterEvent;
use Flasher\Prime\Envelope;

final class PostFilterListener implements EventSubscriberInterface
{
    /**
     * @param PostFilterEvent $event
     *
     * @return Envelope[]
     */
    public function __invoke(PostFilterEvent $event)
    {
        $envelopes = $event->getEnvelopes();

        $envelopes = array_filter($envelopes, static function (Envelope $envelope) {
            $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

            return $hopsStamp->getAmount() > 0;
        });

        $event->setEnvelopes($envelopes);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostFilterEvent';
    }
}
