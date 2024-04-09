<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

/**
 * Event listener interface for handling events.
 * Implementers should define an __invoke method with their specific event type.
 *
 * Example: function __invoke(MyCustomEvent $event): void
 *
 * @method void __invoke(object $event)
 */
interface EventListenerInterface
{
    /**
     * Returns a list of event names this listener wants to listen to.
     *
     * @return string|string[]
     */
    public function getSubscribedEvents(): string|array;
}
