<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Fixtures\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final class NonCallableListener implements EventListenerInterface
{
    private string $eventName;

    public function __construct(string $eventName)
    {
        $this->eventName = $eventName;
    }

    public function getSubscribedEvents(): string
    {
        return $this->eventName;
    }
}
