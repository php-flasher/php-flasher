<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * UpdateEvent - Event dispatched when notifications are being updated.
 *
 * This event is dispatched when notifications are about to be updated in storage.
 * It allows listeners to modify the notifications before they are committed to storage.
 */
final class UpdateEvent
{
    /**
     * Creates a new UpdateEvent instance.
     *
     * @param Envelope[] $envelopes The notification envelopes to be updated
     */
    public function __construct(private array $envelopes)
    {
    }

    /**
     * Gets the notification envelopes to be updated.
     *
     * @return Envelope[] The notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * Sets the notification envelopes to be updated.
     *
     * This allows listeners to modify which notifications will be updated.
     *
     * @param Envelope[] $envelopes The notification envelopes to update
     */
    public function setEnvelopes(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }
}
