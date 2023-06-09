<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class PresentationEvent
{
    /**
     * @param  Envelope[]  $envelopes
     * @param  array<string, mixed>  $context
     */
    public function __construct(
        private readonly array $envelopes,
        private readonly array $context,
    ) {
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * @return array<string, mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
