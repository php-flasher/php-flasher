<?php

namespace Flasher\Prime\EventDispatcher\EventSubscriber;

interface EventSubscriberInterface
{
    /**
     * @return string|array
     */
    public static function getSubscribedEvents();
}
