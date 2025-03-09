<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

/**
 * EnvelopeRemovalListener - Manages notification lifecycle across requests.
 *
 * This listener is responsible for implementing the "hops" feature, which allows
 * notifications to persist across multiple page loads or redirects. When a notification
 * is removed, this listener checks if it has remaining hops and if so, decrements
 * the hop count and keeps the notification in storage.
 *
 * Design patterns:
 * - Chain of Responsibility: Processes each envelope and decides its fate
 * - State: Manages the state transition of notifications across requests
 */
final readonly class EnvelopeRemovalListener implements EventListenerInterface
{
    /**
     * Handles remove events by categorizing envelopes into keep and remove groups.
     *
     * This method processes the envelopes marked for removal, checking if any should
     * be kept based on their hop count.
     *
     * @param RemoveEvent $event The remove event
     */
    public function __invoke(RemoveEvent $event): void
    {
        [$envelopesToKeep, $envelopesToRemove] = $this->categorizeEnvelopes($event->getEnvelopesToRemove());

        $event->setEnvelopesToKeep($envelopesToKeep);
        $event->setEnvelopesToRemove($envelopesToRemove);
    }

    public function getSubscribedEvents(): string
    {
        return RemoveEvent::class;
    }

    /**
     * Categorizes envelopes into those to keep and those to remove.
     *
     * For each envelope:
     * - If it has a HopsStamp with a count > 1, decrement the count and keep it
     * - Otherwise, mark it for removal
     *
     * @param Envelope[] $envelopes The envelopes to categorize
     *
     * @return array<Envelope[]> Array with [0] => envelopes to keep, [1] => envelopes to remove
     */
    private function categorizeEnvelopes(array $envelopes): array
    {
        $envelopesToKeep = [];
        $envelopesToRemove = [];

        foreach ($envelopes as $envelope) {
            $hopsStamp = $envelope->get(HopsStamp::class);

            if ($hopsStamp instanceof HopsStamp && 1 < $hopsStamp->getAmount()) {
                $envelope->withStamp(new HopsStamp($hopsStamp->getAmount() - 1));
                $envelopesToKeep[] = $envelope;
                continue;
            }

            $envelopesToRemove[] = $envelope;
        }

        return [$envelopesToKeep, $envelopesToRemove];
    }
}
