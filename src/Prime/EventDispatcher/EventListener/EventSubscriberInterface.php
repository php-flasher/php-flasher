<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

interface EventSubscriberInterface
{
    /**
     * @return string|array
     */
    public static function getSubscribedEvents();
}
