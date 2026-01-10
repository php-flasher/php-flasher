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

/**
 * StorageManager - Manages notification storage with event dispatch and filtering.
 *
 * This class orchestrates the storage of notifications, dispatching events before and
 * after storage operations, and filtering notifications based on criteria. It acts as
 * a mediator between the storage implementation and the rest of the system.
 *
 * Design patterns:
 * - Mediator: Coordinates operations between storage, filters, and event dispatcher
 * - Decorator: Adds event dispatching and filtering capabilities to the core storage
 */
final readonly class StorageManager implements StorageManagerInterface
{
    /**
     * Creates a new StorageManager instance.
     *
     * @param StorageInterface         $storage         The underlying storage implementation
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher for notification lifecycle events
     * @param FilterFactoryInterface   $filterFactory   Factory for creating notification filters
     * @param array<string, mixed>     $criteria        Default criteria for filtering notifications
     */
    public function __construct(
        private StorageInterface $storage,
        private EventDispatcherInterface $eventDispatcher,
        private FilterFactoryInterface $filterFactory,
        private array $criteria = [],
    ) {
    }

    /**
     * Retrieves all stored envelopes.
     *
     * @return Envelope[]
     */
    public function all(): array
    {
        return $this->storage->all();
    }

    /**
     * Filters notifications by criteria.
     *
     * This method combines default criteria with provided criteria,
     * creates a filter using the filter factory, and applies it to envelopes.
     * Before applying the filter, it dispatches a FilterEvent to allow modification.
     *
     * @param array<string, mixed> $criteria
     *
     * @return Envelope[]
     *
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

    /**
     * Adds notification envelopes to storage.
     *
     * Before adding envelopes, it dispatches a PersistEvent to allow modification
     * of the envelopes. After storage, it dispatches a PostPersistEvent.
     *
     * @param Envelope ...$envelopes
     */
    public function add(Envelope ...$envelopes): void
    {
        $event = new PersistEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->add(...$event->getEnvelopes());

        $event = new PostPersistEvent($event->getEnvelopes());
        $this->eventDispatcher->dispatch($event);
    }

    /**
     * Updates notification envelopes in storage.
     *
     * Before updating envelopes, it dispatches an UpdateEvent to allow modification
     * of the envelopes. After update, it dispatches a PostUpdateEvent.
     *
     * @param Envelope ...$envelopes
     */
    public function update(Envelope ...$envelopes): void
    {
        $event = new UpdateEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update(...$event->getEnvelopes());

        $event = new PostUpdateEvent($event->getEnvelopes());
        $this->eventDispatcher->dispatch($event);
    }

    /**
     * Removes notification envelopes from storage.
     *
     * Before removal, it dispatches a RemoveEvent to allow listeners to modify
     * which envelopes should be removed or kept. After removal, it dispatches
     * a PostRemoveEvent.
     *
     * @param Envelope ...$envelopes
     */
    public function remove(Envelope ...$envelopes): void
    {
        $event = new RemoveEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $this->storage->update(...$event->getEnvelopesToKeep());
        $this->storage->remove(...$event->getEnvelopesToRemove());

        $event = new PostRemoveEvent($event->getEnvelopesToRemove(), $event->getEnvelopesToKeep());
        $this->eventDispatcher->dispatch($event);
    }

    /**
     * Clears all notification envelopes from storage.
     */
    public function clear(): void
    {
        $this->storage->clear();
    }
}
