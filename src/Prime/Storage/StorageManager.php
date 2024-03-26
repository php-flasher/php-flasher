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
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\FilterFactoryInterface;

final readonly class StorageManager implements StorageManagerInterface
{
    /**
     * @param array<string, mixed> $criteria
     */
    public function __construct(
        private StorageInterface $storage,
        private EventDispatcherInterface $eventDispatcher,
        private FilterFactoryInterface $filterFactory,
        private array $criteria = [],
    ) {
    }

    public function all(): array
    {
        return $this->storage->all();
    }

    /**
     * @throws CriteriaNotRegisteredException
     */
    public function filter(array $criteria = []): array
    {
        $criteria = [...$this->criteria, ...$criteria];
        $filter = $this->filterFactory->createFilter($criteria);

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
