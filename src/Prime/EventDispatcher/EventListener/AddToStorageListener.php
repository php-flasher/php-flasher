<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

/**
 * AddToStorageListener - Filters notifications before storage based on conditions.
 *
 * This listener is responsible for checking whether notifications should be stored
 * based on their WhenStamp and UnlessStamp conditions. It allows for conditional
 * notifications that only appear when certain criteria are met.
 *
 * Design patterns:
 * - Filter Chain: Acts as a filter in the notification processing pipeline
 * - Strategy: Applies different filtering strategies based on stamp conditions
 */
final readonly class AddToStorageListener implements EventListenerInterface
{
    /**
     * Handles persist events by filtering notifications based on conditions.
     *
     * This method filters out notifications that don't meet their when/unless conditions.
     *
     * @param PersistEvent $event The persist event
     */
    public function __invoke(PersistEvent $event): void
    {
        $envelopes = array_filter($event->getEnvelopes(), $this->isEligibleForStorage(...));

        $event->setEnvelopes($envelopes);
    }

    public function getSubscribedEvents(): string
    {
        return PersistEvent::class;
    }

    /**
     * Checks if an envelope is eligible for storage based on its conditions.
     *
     * An envelope is eligible if:
     * - It passes its when condition (if any)
     * - It passes its unless condition (if any)
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope should be stored, false otherwise
     */
    private function isEligibleForStorage(Envelope $envelope): bool
    {
        return $this->whenCondition($envelope) && $this->unlessCondition($envelope);
    }

    /**
     * Checks if the envelope passes its when condition.
     *
     * The envelope passes if:
     * - It has no WhenStamp, or
     * - Its WhenStamp condition evaluates to true
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope passes its when condition
     */
    private function whenCondition(Envelope $envelope): bool
    {
        $whenStamp = $envelope->get(WhenStamp::class);

        return !($whenStamp instanceof WhenStamp && !$whenStamp->getCondition());
    }

    /**
     * Checks if the envelope passes its unless condition.
     *
     * The envelope passes if:
     * - It has no UnlessStamp, or
     * - Its UnlessStamp condition evaluates to false
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope passes its unless condition
     */
    private function unlessCondition(Envelope $envelope): bool
    {
        $unlessStamp = $envelope->get(UnlessStamp::class);

        return !($unlessStamp instanceof UnlessStamp && $unlessStamp->getCondition());
    }
}
