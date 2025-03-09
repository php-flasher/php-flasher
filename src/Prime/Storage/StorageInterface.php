<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;

/**
 * StorageInterface - Core contract for notification storage implementations.
 *
 * This interface defines the essential operations for managing notifications
 * in a storage system. Implementations can range from simple in-memory arrays
 * to persistent storage like sessions, databases, or files.
 *
 * Design pattern: Repository - Defines a common interface for storing and
 * retrieving notification envelopes from various storage backends.
 */
interface StorageInterface
{
    /**
     * Retrieves all stored notification envelopes.
     *
     * @return Envelope[] Array of all stored notification envelopes
     */
    public function all(): array;

    /**
     * Adds one or more notification envelopes to the storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to store
     */
    public function add(Envelope ...$envelopes): void;

    /**
     * Updates one or more notification envelopes in the storage.
     *
     * This method should replace existing envelopes with the same identifiers,
     * or add them if they don't exist yet.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to update
     */
    public function update(Envelope ...$envelopes): void;

    /**
     * Removes one or more notification envelopes from the storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to remove
     */
    public function remove(Envelope ...$envelopes): void;

    /**
     * Clears all notification envelopes from the storage.
     */
    public function clear(): void;
}
