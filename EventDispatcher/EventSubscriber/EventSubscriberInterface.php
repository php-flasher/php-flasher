<?php

namespace Flasher\Prime\EventDispatcher\EventSubscriber;

interface EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents();
}
