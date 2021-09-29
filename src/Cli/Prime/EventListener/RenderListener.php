<?php

namespace Flasher\Cli\Prime\EventListener;

use Flasher\Cli\Prime\CliFlasherInterface;
use Flasher\Cli\Prime\Stamp\DesktopStamp;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PostPersistEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;

final class RenderListener implements EventSubscriberInterface
{
    private $flasher;

    public function __construct(CliFlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @param PostPersistEvent $event
     */
    public function __invoke($event)
    {
        if (PHP_SAPI !== 'cli') {
            return;
        }

        $callback = function(Envelope $envelope) {
            $stamp = $envelope->get('Flasher\Cli\Prime\Stamp\DesktopStamp');
            if (!$stamp instanceof DesktopStamp) {
                return false;
            }

            return $stamp->isRenderImmediately();
        };

        $this->flasher->render(array('filter' => $callback));
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostPersistEvent';
    }
}
