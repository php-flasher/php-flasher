<?php

namespace Flasher\Prime\EventDispatcher\Event;

interface StoppableEventInterface
{
    /**
     * @return bool
     */
    public function isPropagationStopped();
}
