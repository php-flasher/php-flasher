<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;

/**
 * StorageManagerInterface - Contract for notification storage management.
 *
 * This interface extends the basic storage operations with filtering capabilities.
 * It defines the contract for the storage manager, which orchestrates the storage,
 * retrieval, and filtering of notification envelopes.
 *
 * Design pattern: Mediator - Defines an interface for coordinating storage operations
 * with additional capabilities like filtering and event dispatch.
 */
interface StorageManagerInterface
{
    /**
     * Retrieves all stored notification envelopes.
     *
     * @return Envelope[] Array of all stored notification envelopes
     */
    public function all(): array;

    /**
     * Filters notifications based on provided criteria.
     *
     * This method allows retrieving a subset of notifications that match
     * specific criteria, such as notification type, priority, or other attributes.
     *
     * @param array<string, mixed> $criteria Filtering criteria
     *
     * @return Envelope[] Array of filtered notification envelopes
     */
    public function filter(array $criteria = []): array;

    /**
     * Adds one or more notification envelopes to storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to store
     */
    public function add(Envelope ...$envelopes): void;

    /**
     * Updates one or more notification envelopes in storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to update
     */
    public function update(Envelope ...$envelopes): void;

    /**
     * Removes one or more notification envelopes from storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to remove
     */
    public function remove(Envelope ...$envelopes): void;

    /**
     * Clears all notification envelopes from storage.
     */
    public function clear(): void;
}
