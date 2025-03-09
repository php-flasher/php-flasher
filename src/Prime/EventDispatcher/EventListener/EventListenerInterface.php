<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

/**
 * EventListenerInterface - Contract for event listeners.
 *
 * This interface defines the essential operations for event listeners in the
 * PHPFlasher event system. Implementers should define an __invoke method that
 * processes events they're interested in and declare which events they listen to.
 *
 * Design patterns:
 * - Observer: Defines a contract for objects that observe and respond to events
 * - Visitor: Allows operations to be performed on event objects
 *
 * Example implementation:
 * ```php
 * class MyListener implements EventListenerInterface
 * {
 *     public function __invoke(MyEvent $event): void
 *     {
 *         // Handle the event
 *     }
 *
 *     public function getSubscribedEvents(): string
 *     {
 *         return MyEvent::class;
 *     }
 * }
 * ```
 *
 * @method void __invoke(object $event) Method that handles the event
 */
interface EventListenerInterface
{
    /**
     * Returns a list of event names this listener wants to listen to.
     *
     * The returned value can be:
     * - A string: Single event class name
     * - An array: Multiple event class names
     *
     * @return string|string[] The event class name(s) this listener subscribes to
     */
    public function getSubscribedEvents(): string|array;
}
