<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\EnvelopeDispatchedEvent;
use Flasher\Prime\Middleware\FlasherBus;

final class MiddlewareListener implements EventSubscriberInterface
{
    /**
     * @var FlasherBus
     */
    private $flasherBus;

    /**
     * @param FlasherBus $flasherBus
     */
    public function __construct(FlasherBus $flasherBus)
    {
        $this->flasherBus = $flasherBus;
    }

    /**
     * @param EnvelopeDispatchedEvent $event
     */
    public function __invoke(EnvelopeDispatchedEvent $event)
    {
        $this->flasherBus->dispatch($event->getEnvelope());
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\EnvelopeDispatchedEvent';
    }
}
