<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

/**
 * BagInterface - Contract for notification envelope storage containers.
 *
 * This interface defines the essential operations for a storage container
 * that can hold notification envelopes. Different implementations can use
 * different storage backends (array, session, etc.).
 *
 * Design pattern: Repository - Defines a simple contract for storing and
 * retrieving notification envelopes.
 */
interface BagInterface
{
    /**
     * Retrieves all stored notification envelopes.
     *
     * @return Envelope[] Array of all stored notification envelopes
     */
    public function get(): array;

    /**
     * Sets the stored notification envelopes.
     *
     * This method should replace all existing envelopes with the provided ones.
     *
     * @param Envelope[] $envelopes The notification envelopes to store
     */
    public function set(array $envelopes): void;
}
