<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\EventListener;

interface EventSubscriberInterface
{
    /**
     * @return string|string[]
     */
    public static function getSubscribedEvents();
}
