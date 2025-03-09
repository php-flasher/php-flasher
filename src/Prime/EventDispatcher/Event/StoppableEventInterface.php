<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

/**
 * StoppableEventInterface - Contract for events that can stop propagation.
 *
 * This interface marks an event as being able to stop propagation through the
 * event dispatcher. Once an event's propagation is stopped, no further listeners
 * will be called for that event.
 *
 * Design pattern: Circuit Breaker - Provides a mechanism to halt the normal
 * flow of execution when certain conditions are met.
 */
interface StoppableEventInterface
{
    /**
     * Checks if event propagation should be stopped.
     *
     * This method returns true if event propagation should be stopped,
     * false otherwise.
     *
     * @return bool True if event propagation should stop, false otherwise
     */
    public function isPropagationStopped(): bool;
}
