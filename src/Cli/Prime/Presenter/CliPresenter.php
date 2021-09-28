<?php

namespace Flasher\Cli\Prime\Presenter;

use Flasher\Cli\Prime\Notifier\NotifierInterface;
use Flasher\Cli\Prime\Notifier\NullNotifier;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Response;

final class CliPresenter implements PresenterInterface
{
    /**
     * @var NotifierInterface[]
     */
    private $notifiers = array();

    public function render(Response $response)
    {
        $notifier = $this->createNotifier();

        $notifier->render($response->getEnvelopes());
    }

    public function addNotifier(NotifierInterface $notifier)
    {
        $this->notifiers[] = $notifier;
    }

    /**
     * @return NotifierInterface
     */
    private function createNotifier()
    {
        foreach ($this->notifiers as $notifier) {
            if ($notifier->isSupported()) {
                return $notifier;
            }
        }

        return new NullNotifier();
    }
}
