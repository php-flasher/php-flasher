<?php

namespace Flasher\Prime\EventDispatcher\EventSubscriber;

use Flasher\Prime\EventDispatcher\Event\PostFlushEvent;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Storage\StorageInterface;

class RemoveRenderedEnvelopesSubscriber implements EventSubscriberInterface
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
     * @param PostFlushEvent $event
     */
    public function __invoke(PostFlushEvent $event)
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $replayStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
            $replayCount = null === $replayStamp ? 0 : $replayStamp->getAmount() - 1;

            if (1 > $replayCount) {
                continue;
            }

            $envelope->with(new HopsStamp($replayCount));
            $this->storage->add($envelope);
        }
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostFlushEvent';
    }
}
