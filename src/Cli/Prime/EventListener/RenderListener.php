<?php

namespace Flasher\Cli\Prime\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Prime\FlasherInterface;

class RenderListener implements EventSubscriberInterface
{
    private $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @param PersistEvent $event
     */
    public function __invoke($event)
    {
        return;
        if (PHP_SAPI !== 'cli') {
            return;
        }

        $envelopes = $event->getEnvelopes();

        $this->FlasherCli->render($envelopes);
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PersistEvent';
    }
}
