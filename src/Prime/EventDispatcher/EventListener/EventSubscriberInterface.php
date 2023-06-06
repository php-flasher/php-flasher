<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

interface EventSubscriberInterface
{
    /**
     * @return string|string[]
     */
    public static function getSubscribedEvents();
}
