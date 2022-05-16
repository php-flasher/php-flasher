<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime\Presenter;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\Notify;
use Flasher\Cli\Prime\NotifyInterface;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Response;

final class CliPresenter implements PresenterInterface
{
    const NAME = 'cli';

    /**
     * @var NotifyInterface
     */
    private $notifier;

    public function __construct(NotifyInterface $notifier = null)
    {
        $this->notifier = $notifier ?: new Notify();
    }

    /**
     * {@inheritdoc}
     */
    public function render(Response $response)
    {
        if ('cli' !== \PHP_SAPI || array() === $response->getEnvelopes()) {
            return;
        }

        foreach ($response->getEnvelopes() as $envelope) {
            $notification = Notification::fromEnvelope($envelope);
            $this->notifier->send($notification);
        }
    }
}
