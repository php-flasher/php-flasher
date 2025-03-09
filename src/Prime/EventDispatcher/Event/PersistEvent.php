<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * PersistEvent - Event dispatched when notifications are being persisted.
 *
 * This event is dispatched when notifications are about to be added to storage.
 * It allows listeners to modify the notifications before they are stored.
 */
final class PersistEvent
{
    /**
     * Creates a new PersistEvent instance.
     *
     * @param Envelope[] $envelopes The notification envelopes to be persisted
     */
    public function __construct(private array $envelopes)
    {
    }

    /**
     * Gets the notification envelopes to be persisted.
     *
     * @return Envelope[] The notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * Sets the notification envelopes to be persisted.
     *
     * This allows listeners to filter or modify the notifications before storage.
     *
     * @param Envelope[] $envelopes The notification envelopes to persist
     */
    public function setEnvelopes(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }
}
