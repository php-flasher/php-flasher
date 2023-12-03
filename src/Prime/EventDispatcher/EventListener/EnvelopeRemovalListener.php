<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Stamp\HopsStamp;

final class EnvelopeRemovalListener implements EventListenerInterface
{
    public function __invoke(RemoveEvent $event): void
    {
        [$envelopesToKeep, $envelopesToRemove] = $this->categorizeEnvelopes($event->getEnvelopesToRemove());

        $event->setEnvelopesToKeep($envelopesToKeep);
        $event->setEnvelopesToRemove($envelopesToRemove);
    }

    public static function getSubscribedEvents(): string
    {
        return RemoveEvent::class;
    }

    private function categorizeEnvelopes(array $envelopes): array
    {
        $envelopesToKeep = [];
        $envelopesToRemove = [];

        foreach ($envelopes as $envelope) {
            $hopsStamp = $envelope->get(HopsStamp::class);

            if (!$this->shouldRemove($hopsStamp)) {
                $envelope = $this->decrementHops($envelope, $hopsStamp);
                $envelopesToKeep[] = $envelope;
                continue;
            }

            $envelopesToRemove[] = $envelope;
        }

        return [$envelopesToKeep, $envelopesToRemove];
    }

    private function shouldRemove(?HopsStamp $hopsStamp): bool
    {
        return !$hopsStamp instanceof HopsStamp || 1 === $hopsStamp->getAmount();
    }

    private function decrementHops($envelope, HopsStamp $hopsStamp): object
    {
        return $envelope->withStamp(new HopsStamp($hopsStamp->getAmount() - 1));
    }
}
