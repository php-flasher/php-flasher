<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PostFilterEvent;
use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Storage\StorageInterface;

final class PostFilterListener implements EventSubscriberInterface
{
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param PostFilterEvent $event
     *
     * @return Envelope[]
     */
    public function __invoke(PostFilterEvent $event)
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
            $this->storage->update($envelope);
        }

        $event->setEnvelopes($filtered);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostFilterEvent';
    }
}
