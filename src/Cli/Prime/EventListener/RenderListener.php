<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\EventListener;

use Flasher\Cli\Prime\Presenter\CliPresenter;
use Flasher\Prime\EventDispatcher\Event\PostPersistEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Prime\FlasherInterface;

final class RenderListener implements EventListenerInterface
{
    public function __construct(private readonly FlasherInterface $flasher)
    {
    }

    /**
     * @return void
     */
    public function __invoke(PostPersistEvent $event)
    {
        if ('cli' !== \PHP_SAPI) {
            return;
        }

        $this->flasher->render([], CliPresenter::NAME);
    }

    public static function getSubscribedEvents(): string|array
    {
        return \Flasher\Prime\EventDispatcher\Event\PostPersistEvent::class;
    }
}
