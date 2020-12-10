<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PreFlushEvent;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Storage\StorageManagerInterface;

final class RemoveListener implements EventSubscriberInterface
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
     * @param PreFlushEvent $event
     */
    public function __invoke(PreFlushEvent $event)
    {
        $envelopesToKeep = array();
        $envelopesToRemove = array();

        foreach ($event->getEnvelopes() as $envelope) {
            $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

            if (1 === $hopsStamp->getAmount()) {
                $envelopesToRemove[] = $envelope;
                continue;
            }

            $envelope->with(new HopsStamp($hopsStamp->getAmount() - 1));
            $envelopesToKeep[] = $envelope;
        }

        $event->setEnvelopes($envelopesToRemove);
        $this->storageManager->update($envelopesToKeep);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PreFlushEvent';
    }
}
