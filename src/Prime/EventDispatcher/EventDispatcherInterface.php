<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

interface EventDispatcherInterface
{
    /**
     * @phpstan-template T of object
     *
     * @phpstan-param T $event
     *
     * @phpstan-return T
     */
    public function dispatch(object $event): object;

    public function addListener(EventListenerInterface $listener): void;

    /**
     * @return EventListenerInterface[]
     */
    public function getListeners(string $eventName): array;
}
