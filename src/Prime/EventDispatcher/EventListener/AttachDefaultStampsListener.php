<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PriorityStamp;

/**
 * AttachDefaultStampsListener - Ensures notifications have required stamps.
 *
 * This listener is responsible for ensuring that all notification envelopes
 * have the required system stamps. These stamps provide essential functionality
 * like identification, timing, and lifecycle management.
 *
 * Design patterns:
 * - Decorator: Adds default stamps to notification envelopes
 * - Template Method: Defines a standard set of stamps for all notifications
 */
final readonly class AttachDefaultStampsListener implements EventListenerInterface
{
    /**
     * Handles persist and update events by attaching default stamps.
     *
     * @param PersistEvent|UpdateEvent $event The event to handle
     */
    public function __invoke(PersistEvent|UpdateEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachStamps($envelope);
        }
    }

    /**
     * {@inheritdoc}
     *
     * This listener subscribes to both persist and update events to ensure
     * that stamps are attached to notifications in both scenarios.
     *
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            PersistEvent::class,
            UpdateEvent::class,
        ];
    }

    /**
     * Attaches default stamps to an envelope if they don't already exist.
     *
     * The default stamps are:
     * - CreatedAtStamp: Records when the notification was created
     * - IdStamp: Provides a unique identifier
     * - DelayStamp: Controls display timing (default: immediate)
     * - HopsStamp: Controls persistence across requests (default: 1 request)
     * - PriorityStamp: Controls display order (default: normal priority)
     *
     * @param Envelope $envelope The envelope to attach stamps to
     */
    private function attachStamps(Envelope $envelope): void
    {
        $envelope->withStamp(new CreatedAtStamp(), false);
        $envelope->withStamp(new IdStamp(), false);
        $envelope->withStamp(new DelayStamp(0), false);
        $envelope->withStamp(new HopsStamp(1), false);
        $envelope->withStamp(new PriorityStamp(0), false);
    }
}
