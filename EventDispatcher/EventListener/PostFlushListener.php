<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PreFlushEvent;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Storage\StorageManagerInterface;

final class PostFlushListener implements EventSubscriberInterface
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
        foreach ($event->getEnvelopes() as $envelope) {
            $replayStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
            $replayCount = null === $replayStamp ? 0 : $replayStamp->getAmount() - 1;

            if (1 > $replayCount) {
                continue;
            }

            $envelope->with(new HopsStamp($replayCount));
            $this->storageManager->add($envelope);
        }
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PreFlushEvent';
    }
}
