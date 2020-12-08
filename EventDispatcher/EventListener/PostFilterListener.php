<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Storage\StorageManagerInterface;

final class PostFilterListener implements EventSubscriberInterface
{
    /**
     * @var StorageManagerInterface
     */
    private $storageManager;

    /**
     * @param StorageManagerInterface $storageManager
     */
    public function __construct(StorageManagerInterface $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * @param FilterEvent $event
     *
     * @return Envelope[]
     */
    public function __invoke(FilterEvent $event)
    {
        $envelopes = $event->getEnvelopes();
        $filtered = array();

        foreach ($envelopes as $envelope) {
            $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
            $delayStamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');

            if (0 < $hopsStamp->getAmount() && 0 === $delayStamp->getDelay()) {
                $filtered[] = $envelope;

                continue;
            }

            $envelope->withStamp(new DelayStamp($delayStamp->getDelay() - 1));
            $this->storageManager->update($envelope);
        }

        $event->setEnvelopes($filtered);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\FilterEvent';
    }
}
