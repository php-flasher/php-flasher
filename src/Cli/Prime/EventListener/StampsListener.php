<?php

namespace Flasher\Cli\Prime\EventListener;

use Flasher\Cli\Prime\Stamp\DesktopStamp;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;

final class StampsListener implements EventSubscriberInterface
{
    private $renderAll;
    private $renderImmediately;

    public function __construct($renderAll, $renderImmediately)
    {
        $this->renderAll = $renderAll;
        $this->renderImmediately = $renderImmediately;
    }

    /**
     * @param PersistEvent|UpdateEvent $event
     */
    public function __invoke($event)
    {
        if (PHP_SAPI !== 'cli') {
            return;
        }

        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachStamps($envelope);
        }
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PersistEvent';
    }

    private function attachStamps(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Cli\Prime\Stamp\DesktopStamp');
        if (null === $stamp && true === $this->renderAll) {
            $envelope->withStamp(new DesktopStamp($this->renderImmediately));
        }
    }
}
