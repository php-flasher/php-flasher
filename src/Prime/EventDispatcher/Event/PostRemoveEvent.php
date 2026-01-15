<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * Event dispatched after notifications are removed.
 */
final readonly class PostRemoveEvent
{
    /**
     * @param Envelope[] $envelopesToRemove
     * @param Envelope[] $envelopesToKeep
     */
    public function __construct(
        private array $envelopesToRemove = [],
        private array $envelopesToKeep = [],
    ) {
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToRemove(): array
    {
        return $this->envelopesToRemove;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToKeep(): array
    {
        return $this->envelopesToKeep;
    }
}
