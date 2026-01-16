<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final readonly class EnvelopeRemovalListener implements EventListenerInterface
{
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
     * @param Envelope[] $envelopes
     *
     * @return array<Envelope[]>
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
