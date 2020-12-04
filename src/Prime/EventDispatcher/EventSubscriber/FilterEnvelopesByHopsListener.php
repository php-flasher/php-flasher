<?php

namespace Flasher\Prime\EventDispatcher\EventSubscriber;

use Flasher\Prime\EventDispatcher\Event\EnvelopesEvent;
use Flasher\Prime\Envelope;

final class FilterEnvelopesByHopsListener implements EventSubscriberInterface
{
    /**
     * @param EnvelopesEvent $event
     *
     * @return Envelope[]
     */
    public function __invoke(EnvelopesEvent $event)
    {
        $envelopes = $event->getEnvelopes();

        $envelopes = array_filter(
            $envelopes,
            static function (Envelope $envelope) {
                $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

                return $hopsStamp->getAmount() > 0;
            }
        );

        $event->setEnvelopes($envelopes);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Flasher\Prime\EventDispatcher\Event\EnvelopesEvent'
        );
    }
}
