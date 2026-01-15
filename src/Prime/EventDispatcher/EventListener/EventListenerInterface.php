<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

/**
 * Contract for event listeners.
 */
interface EventListenerInterface
{
    /**
     * @return string|string[]
     */
    public function getSubscribedEvents(): string|array;
}
