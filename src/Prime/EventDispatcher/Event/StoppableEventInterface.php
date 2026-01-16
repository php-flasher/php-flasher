<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

interface StoppableEventInterface
{
    public function isPropagationStopped(): bool;
}
