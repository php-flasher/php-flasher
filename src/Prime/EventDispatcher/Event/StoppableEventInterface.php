<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

/**
 * Contract for events that can stop propagation.
 */
interface StoppableEventInterface
{
    public function isPropagationStopped(): bool;
}
