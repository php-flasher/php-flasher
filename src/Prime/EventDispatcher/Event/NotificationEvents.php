<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * NotificationEvents - Collector for notification envelopes.
 *
 * This class provides a simple container for collecting notification envelopes
 * during various system processes. It's primarily used by logging and debugging
 * listeners to track which notifications were dispatched or displayed.
 *
 * Design pattern: Collection - Provides a way to collect and access notification
 * envelopes in a consistent manner.
 *
 * @internal This class is not part of the public API and may change without notice
 */
final class NotificationEvents
{
    /**
     * The collected notification envelopes.
     *
     * @var Envelope[]
     */
    private array $envelopes = [];

    /**
     * Adds multiple notification envelopes to the collection.
     *
     * @param Envelope ...$notifications The notification envelopes to add
     */
    public function add(Envelope ...$notifications): void
    {
        foreach ($notifications as $notification) {
            $this->addEnvelope($notification);
        }
    }

    /**
     * Adds a single notification envelope to the collection.
     *
     * @param Envelope $notification The notification envelope to add
     */
    public function addEnvelope(Envelope $notification): void
    {
        $this->envelopes[] = $notification;
    }

    /**
     * Gets all the collected notification envelopes.
     *
     * @return Envelope[] The collected notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }
}
