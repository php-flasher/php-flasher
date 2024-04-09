<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Fixtures\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\Event\StoppableEvent;

final class StoppableEventListener implements EventListenerInterface
{
    public function __invoke(StoppableEvent $event): void
    {
        $event->stopPropagation();
    }

    public function getSubscribedEvents(): string
    {
        return StoppableEvent::class;
    }
}
