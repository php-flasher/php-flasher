<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Bag\BagInterface;

/**
 * Storage - Default implementation of the storage interface.
 *
 * This class provides a standard implementation of StorageInterface that
 * delegates to a storage bag. It handles identity tracking using IdStamp
 * to ensure unique envelopes in storage.
 *
 * Design patterns:
 * - Adapter: Adapts the bag interface to the storage interface
 * - Decorator: Adds identity tracking to the underlying storage bag
 */
final readonly class Storage implements StorageInterface
{
    /**
     * Creates a new Storage instance.
     *
     * @param BagInterface $bag The underlying storage bag implementation
     */
    public function __construct(private BagInterface $bag)
    {
    }

    /**
     * Retrieves all stored notification envelopes.
     *
     * @return Envelope[] Array of all stored notification envelopes as values
     */
    public function all(): array
    {
        return array_values($this->bag->get());
    }

    /**
     * Adds one or more notification envelopes to the storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to store
     */
    public function add(Envelope ...$envelopes): void
    {
        $this->save(...$envelopes);
    }

    /**
     * Updates one or more notification envelopes in the storage.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to update
     */
    public function update(Envelope ...$envelopes): void
    {
        $this->save(...$envelopes);
    }

    /**
     * Removes one or more notification envelopes from the storage.
     *
     * This method filters out the specified envelopes from storage based on their IDs.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to remove
     */
    public function remove(Envelope ...$envelopes): void
    {
        $envelopes = IdStamp::indexById($envelopes);
        $stored = IdStamp::indexById($this->all());
        $envelopes = array_diff_key($stored, $envelopes);

        $this->bag->set(array_values($envelopes));
    }

    /**
     * Clears all notification envelopes from the storage.
     */
    public function clear(): void
    {
        $this->bag->set([]);
    }

    /**
     * Internal helper method to save envelopes.
     *
     * This method indexes envelopes by their IDs, merges them with existing envelopes,
     * and updates the storage bag. New envelopes replace existing ones with the same ID.
     *
     * @param Envelope ...$envelopes One or more notification envelopes to save
     */
    private function save(Envelope ...$envelopes): void
    {
        $envelopes = IdStamp::indexById($envelopes);
        $stored = IdStamp::indexById($this->all());
        $envelopes = [...$stored, ...$envelopes];

        $this->bag->set(array_values($envelopes));
    }
}
