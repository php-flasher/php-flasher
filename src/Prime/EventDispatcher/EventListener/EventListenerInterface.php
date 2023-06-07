<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

interface EventListenerInterface
{
    /**
     * @return string|string[]
     */
    public static function getSubscribedEvents(): string|array;
}
