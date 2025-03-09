<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * RemoveEvent - Event dispatched when notifications are being removed.
 *
 * This event is dispatched when notifications are about to be removed from storage.
 * It allows listeners to modify which notifications should be removed and which
 * should be kept. This is used for implementing hopping behavior where notifications
 * can persist across multiple requests.
 */
final class RemoveEvent
{
    /**
     * Notification envelopes that should be kept in storage.
     *
     * @var Envelope[]
     */
    private array $envelopesToKeep = [];

    /**
     * Creates a new RemoveEvent instance.
     *
     * @param Envelope[] $envelopesToRemove The notification envelopes initially marked for removal
     */
    public function __construct(private array $envelopesToRemove)
    {
    }

    /**
     * Gets the notification envelopes marked for removal.
     *
     * @return Envelope[] The notification envelopes to remove
     */
    public function getEnvelopesToRemove(): array
    {
        return $this->envelopesToRemove;
    }

    /**
     * Sets the notification envelopes to be removed.
     *
     * @param Envelope[] $envelopesToRemove The notification envelopes to remove
     */
    public function setEnvelopesToRemove(array $envelopesToRemove): void
    {
        $this->envelopesToRemove = $envelopesToRemove;
    }

    /**
     * Gets the notification envelopes that should be kept in storage.
     *
     * @return Envelope[] The notification envelopes to keep
     */
    public function getEnvelopesToKeep(): array
    {
        return $this->envelopesToKeep;
    }

    /**
     * Sets the notification envelopes that should be kept in storage.
     *
     * @param Envelope[] $envelopesToKeep The notification envelopes to keep
     */
    public function setEnvelopesToKeep(array $envelopesToKeep): void
    {
        $this->envelopesToKeep = $envelopesToKeep;
    }
}
