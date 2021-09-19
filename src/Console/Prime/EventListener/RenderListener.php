<?php

namespace Flasher\Console\Prime\EventListener;

use Flasher\Console\Prime\FlasherConsole;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;

class RenderListener implements EventSubscriberInterface
{
    private $flasherConsole;

    public function __construct(FlasherConsole $flasherConsole)
    {
        $this->flasherConsole = $flasherConsole;
    }

    /**
     * @param PersistEvent $event
     */
    public function __invoke($event)
    {
        if (PHP_SAPI !== 'cli') {
            return;
        }

        $envelopes = $event->getEnvelopes();

        $this->flasherConsole->render($envelopes);
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PersistEvent';
    }
}
