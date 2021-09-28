<?php

namespace Flasher\Cli\Prime\EventListener;

use Flasher\Cli\Prime\Stamp\DesktopStamp;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PostPersistEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Prime\FlasherInterface;

final class RenderListener implements EventSubscriberInterface
{
    private $flasher;

    public function __construct(FlasherInterface $flasher)
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

        $this->flasher->render(array('filter' => $callback), 'cli');
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostPersistEvent';
    }
}
