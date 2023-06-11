<?php

declare(strict_types=1);

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
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\Filter;
use Flasher\Prime\Storage\Filter\FilterFactory;

final class StorageManager implements StorageManagerInterface
{
    private readonly StorageInterface $storage;

    private readonly EventDispatcherInterface $eventDispatcher;
    private readonly FilterFactory $filterFactory;

    /**
     * @param  array<string, mixed>  $criteria
     */
    public function __construct(
        StorageInterface $storage = null,
        EventDispatcherInterface $eventDispatcher = null,
        FilterFactory $filterFactory = null,
        private readonly array $criteria = [],
    ) {
        $this->storage = $storage ?: new StorageBag();
        $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();
        $this->filterFactory = $filterFactory ?: new FilterFactory();
    }

    public function all(): array
    {
        return $this->storage->all();
    }

    public function filter(array $criteria = []): array
    {
        $filter = $this->filterFactory->createFilter(array_merge($this->criteria, $criteria));

        $event = new FilterEvent($filter, $this->all(), $criteria);
        $this->eventDispatcher->dispatch($event);

        return $event->getFilter()->apply($event->getEnvelopes());
    }

    public function add(Envelope ...$envelopes): void
    {
        $event = new PersistEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->add(...$event->getEnvelopes());

        $event = new PostPersistEvent($event->getEnvelopes());
        $this->eventDispatcher->dispatch($event);
    }

    public function update(Envelope ...$envelopes): void
    {
        $event = new UpdateEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update(...$event->getEnvelopes());

        $event = new PostUpdateEvent($event->getEnvelopes());
        $this->eventDispatcher->dispatch($event);
    }

    public function remove(Envelope ...$envelopes): void
    {
        $event = new RemoveEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update(...$event->getEnvelopesToKeep());
        $this->storage->remove(...$event->getEnvelopesToRemove());

        $event = new PostRemoveEvent($event->getEnvelopesToRemove(), $event->getEnvelopesToKeep());
        $this->eventDispatcher->dispatch($event);
    }

    public function clear(): void
    {
        $this->storage->clear();
    }
}
