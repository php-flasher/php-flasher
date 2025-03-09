<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * PostUpdateEvent - Event dispatched after notification envelopes are updated.
 *
 * This event is dispatched after notification envelopes have been updated in storage.
 * It allows listeners to perform actions based on the updated notifications.
 */
final readonly class PostUpdateEvent
{
    /**
     * Creates a new PostUpdateEvent instance.
     *
     * @param Envelope[] $envelopes The updated notification envelopes
     */
    public function __construct(private array $envelopes)
    {
    }

    /**
     * Gets the updated notification envelopes.
     *
     * @return Envelope[] The updated notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }
}
