<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

interface EventSubscriberInterface
{
    /**
     * @return string|string[]|array<string, string[]>|mixed[]
     */
    public static function getSubscribedEvents();
}
