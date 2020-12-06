<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\EnvelopeDispatchedEvent;
use Flasher\Prime\Storage\StorageInterface;

final class StorageListener implements EventSubscriberInterface
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

    public function __invoke(EnvelopeDispatchedEvent $event)
    {
        $this->storage->add($event->getEnvelope());
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\EnvelopeDispatchedEvent';
    }
}
