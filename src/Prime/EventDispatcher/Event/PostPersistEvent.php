<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final readonly class PostPersistEvent
{
    /**
     * @param Envelope[] $envelopes
     */
    public function __construct(private array $envelopes)
    {
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }
}
