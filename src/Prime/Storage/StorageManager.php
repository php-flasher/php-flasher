<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;

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

        $event = new PersistEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->add($event->getEnvelopes());
    }

    /**
     * @inheritDoc
     */
    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $event = new UpdateEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update($event->getEnvelopes());
    }

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $event = new RemoveEvent($envelopes);
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
