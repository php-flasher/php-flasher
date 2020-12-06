<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PostFlushEvent;
use Flasher\Prime\EventDispatcher\Event\PreFlushEvent;
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
    public function flush($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $event = new PreFlushEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->remove($event->getEnvelopes());

        $event = new PostFlushEvent($envelopes);
        $this->eventDispatcher->dispatch($event);
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
    public function add(Envelope $envelope)
    {
        $this->storage->add($envelope);
    }

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $this->storage->remove($envelopes);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->storage->clear();
    }
}
