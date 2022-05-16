<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime\EventListener;

use Flasher\Cli\Prime\Presenter\CliPresenter;
use Flasher\Prime\EventDispatcher\Event\PostPersistEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Prime\FlasherInterface;

final class RenderListener implements EventSubscriberInterface
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @return void
     */
    public function __invoke(PostPersistEvent $event)
    {
        if ('cli' !== \PHP_SAPI) {
            return;
        }

        $this->flasher->render(array(), CliPresenter::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostPersistEvent';
    }
}
