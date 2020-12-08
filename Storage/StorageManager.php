<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\EventDispatcher\Event\PrePersistEvent;
use Flasher\Prime\EventDispatcher\Event\PreRemoveEvent;
use Flasher\Prime\EventDispatcher\Event\PreUpdateEvent;

final class StorageManager implements StorageManagerInterface
{
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param StorageInterface         $storage
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(StorageInterface $storage, EventDispatcherInterface $eventDispatcher)
    {
        $this->storage = $storage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->storage->all();
    }

    /**
     * @inheritDoc
     */
    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $event = new PrePersistEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->add($event->getEnvelopes());
    }

    /**
     * @inheritDoc
     */
    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $event = new PreUpdateEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update($event->getEnvelopes());
    }

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $event = new PreRemoveEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->remove($event->getEnvelopes());
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->storage->clear();
    }
}
