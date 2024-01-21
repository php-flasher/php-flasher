<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Fixtures\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\Event\InvokeableEvent;

final class InvokeableEventListener implements EventListenerInterface
{
    public function __invoke(InvokeableEvent $event): void
    {
        $event->invoke();
    }

    public function getSubscribedEvents(): string
    {
        return InvokeableEvent::class;
    }
}
