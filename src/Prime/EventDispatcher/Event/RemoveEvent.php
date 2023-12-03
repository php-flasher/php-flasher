<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class RemoveEvent
{
    /**
     * @var Envelope[]
     */
    private array $envelopesToKeep = [];

    /**
     * @param Envelope[] $envelopesToRemove
     */
    public function __construct(private array $envelopesToRemove)
    {
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToRemove(): array
    {
        return $this->envelopesToRemove;
    }

    /**
     * @param Envelope[] $envelopesToRemove
     */
    public function setEnvelopesToRemove(array $envelopesToRemove): void
    {
        $this->envelopesToRemove = $envelopesToRemove;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToKeep(): array
    {
        return $this->envelopesToKeep;
    }

    /**
     * @param Envelope[] $envelopesToKeep
     */
    public function setEnvelopesToKeep(array $envelopesToKeep): void
    {
        $this->envelopesToKeep = $envelopesToKeep;
    }
}
