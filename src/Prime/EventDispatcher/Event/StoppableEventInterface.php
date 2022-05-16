<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\Event;

interface StoppableEventInterface
{
    /**
     * @return bool
     */
    public function isPropagationStopped();
}
