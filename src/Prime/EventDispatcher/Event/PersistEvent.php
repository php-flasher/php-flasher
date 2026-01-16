<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class PersistEvent
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

    /**
     * @param Envelope[] $envelopes
     */
    public function setEnvelopes(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }
}
