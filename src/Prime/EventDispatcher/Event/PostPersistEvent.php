<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * PostPersistEvent - Event dispatched after notifications are persisted.
 *
 * This event is dispatched after notification envelopes have been added to storage.
 * It allows listeners to perform actions after notifications have been successfully stored.
 */
final readonly class PostPersistEvent
{
    /**
     * Creates a new PostPersistEvent instance.
     *
     * @param Envelope[] $envelopes The notification envelopes that were persisted
     */
    public function __construct(private array $envelopes)
    {
    }

    /**
     * Gets the notification envelopes that were persisted.
     *
     * @return Envelope[] The persisted notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }
}
