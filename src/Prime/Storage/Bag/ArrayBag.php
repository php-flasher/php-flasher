<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

/**
 * ArrayBag - In-memory storage bag for notifications.
 *
 * This class provides a simple implementation of the storage bag interface
 * that stores notification envelopes in a instance-level array. It's suitable
 * for testing or applications with short-lived processes.
 *
 * Design pattern: Value Object - Provides a simple container for notification storage.
 */
final class ArrayBag implements BagInterface
{
    /**
     * The stored notification envelopes.
     *
     * @var Envelope[]
     */
    private array $envelopes = [];

    /**
     * Retrieves all stored notification envelopes.
     *
     * @return Envelope[] Array of all stored notification envelopes
     */
    public function get(): array
    {
        return $this->envelopes;
    }

    /**
     * Sets the stored notification envelopes.
     *
     * This method replaces all existing envelopes with the provided ones.
     *
     * @param Envelope[] $envelopes The notification envelopes to store
     */
    public function set(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }
}
