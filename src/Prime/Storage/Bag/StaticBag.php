<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

/**
 * StaticBag - Static/global storage bag for notifications.
 *
 * This class provides an implementation of the storage bag interface that
 * stores notification envelopes in a static class-level array. This allows
 * sharing notifications across multiple instances of the bag class.
 *
 * Design pattern: Value Object with Singleton state - Provides a container
 * for notification storage with globally shared state.
 */
final class StaticBag implements BagInterface
{
    /**
     * The stored notification envelopes (shared across all instances).
     *
     * @var Envelope[]
     */
    private static array $envelopes = [];

    /**
     * Retrieves all stored notification envelopes.
     *
     * @return Envelope[] Array of all stored notification envelopes
     */
    public function get(): array
    {
        return self::$envelopes;
    }

    /**
     * Sets the stored notification envelopes.
     *
     * This method replaces all existing envelopes with the provided ones
     * in the shared static storage.
     *
     * @param Envelope[] $envelopes The notification envelopes to store
     */
    public function set(array $envelopes): void
    {
        self::$envelopes = $envelopes;
    }
}
