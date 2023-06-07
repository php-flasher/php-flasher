<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Presenter;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\Notify;
use Flasher\Cli\Prime\NotifyInterface;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Response;

final class CliPresenter implements PresenterInterface
{
    /**
     * @var string
     */
    public const NAME = 'cli';

    private readonly \Flasher\Cli\Prime\NotifyInterface|\Flasher\Cli\Prime\Notify $notifier;

    public function __construct(NotifyInterface $notifier = null)
    {
        $this->notifier = $notifier ?: new Notify();
    }

    public function render(Response $response): void
    {
        if ('cli' !== \PHP_SAPI || [] === $response->getEnvelopes()) {
            return;
        }

        foreach ($response->getEnvelopes() as $envelope) {
            $notification = Notification::fromEnvelope($envelope);
            $this->notifier->send($notification);
        }
    }
}
