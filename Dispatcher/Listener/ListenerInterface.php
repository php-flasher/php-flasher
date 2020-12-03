<?php

namespace Flasher\Prime\Dispatcher\Listener;

use Flasher\Prime\Dispatcher\Event\EventInterface;

interface ListenerInterface
{
    public function handle(EventInterface $event);
}
