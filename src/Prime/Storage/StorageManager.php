<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\PostPersistEvent;
use Flasher\Prime\EventDispatcher\Event\PostRemoveEvent;
use Flasher\Prime\EventDispatcher\Event\PostUpdateEvent;
use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
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
     * @var mixed[]
     */
    private $criteria = [];

    /**
     * @param mixed[] $criteria
     */
    public function __construct(StorageInterface $storage = null, EventDispatcherInterface $eventDispatcher = null, array $criteria = [])
    {
        $this->storage = $storage ?: new StorageBag();
        $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();
        $this->criteria = $criteria;
    }

    public function all()
    {
        return $this->storage->all();
    }

    public function filter(array $criteria = [])
    {
        $criteria = array_merge($this->criteria, $criteria);

        $criteria['delay'] = 0;
        // @phpstan-ignore-next-line
        $criteria['hops']['min'] = 1;

        $event = new FilterEvent($this->all(), $criteria);
        $this->eventDispatcher->dispatch($event);

        return $event->getEnvelopes();
    }

    public function add($envelopes)
    {
        $envelopes = \is_array($envelopes) ? $envelopes : \func_get_args();

        $event = new PersistEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->add($event->getEnvelopes());

        $event = new PostPersistEvent($event->getEnvelopes());
        $this->eventDispatcher->dispatch($event);
    }

    public function update($envelopes)
    {
        $envelopes = \is_array($envelopes) ? $envelopes : \func_get_args();

        $event = new UpdateEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update($event->getEnvelopes());

        $event = new PostUpdateEvent($event->getEnvelopes());
        $this->eventDispatcher->dispatch($event);
    }

    public function remove($envelopes)
    {
        $envelopes = \is_array($envelopes) ? $envelopes : \func_get_args();

        $event = new RemoveEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update($event->getEnvelopesToKeep());
        $this->storage->remove($event->getEnvelopesToRemove());

        $event = new PostRemoveEvent($event->getEnvelopesToRemove(), $event->getEnvelopesToKeep());
        $this->eventDispatcher->dispatch($event);
    }

    public function clear()
    {
        $this->storage->clear();
    }
}
