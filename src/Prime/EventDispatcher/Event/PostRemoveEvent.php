<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * PostRemoveEvent - Event dispatched after notifications are removed.
 *
 * This event is dispatched after notification envelopes have been removed from or
 * kept in storage. It provides information about which envelopes were removed
 * and which were kept.
 */
final readonly class PostRemoveEvent
{
    /**
     * Creates a new PostRemoveEvent instance.
     *
     * @param Envelope[] $envelopesToRemove The notification envelopes that were removed
     * @param Envelope[] $envelopesToKeep   The notification envelopes that were kept
     */
    public function __construct(
        private array $envelopesToRemove = [],
        private array $envelopesToKeep = [],
    ) {
    }

    /**
     * Gets the notification envelopes that were removed.
     *
     * @return Envelope[] The removed notification envelopes
     */
    public function getEnvelopesToRemove(): array
    {
        return $this->envelopesToRemove;
    }

    /**
     * Gets the notification envelopes that were kept.
     *
     * @return Envelope[] The kept notification envelopes
     */
    public function getEnvelopesToKeep(): array
    {
        return $this->envelopesToKeep;
    }
}
