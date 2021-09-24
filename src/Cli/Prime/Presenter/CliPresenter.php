<?php

namespace Flasher\Cli\Prime\Presenter;

use Flasher\Cli\Prime\Notifier\GrowlNotifyNotifier;
use Flasher\Cli\Prime\Notifier\KDialogNotifier;
use Flasher\Cli\Prime\Notifier\NotifierInterface;
use Flasher\Cli\Prime\Notifier\NotifuNotifier;
use Flasher\Cli\Prime\Notifier\NotifySendNotifier;
use Flasher\Cli\Prime\Notifier\NullNotifier;
use Flasher\Cli\Prime\Notifier\SnoreToastNotifier;
use Flasher\Cli\Prime\Notifier\TerminalNotifierNotifier;
use Flasher\Cli\Prime\Notifier\ToasterNotifier;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Response;

final class CliPresenter implements PresenterInterface
{
    /**
     * @var NotifierInterface[]
     */
    private $notifiers = array();

    public function __construct()
    {
        $this->notifiers = array(
            new GrowlNotifyNotifier(),
            new NotifuNotifier(),
            new TerminalNotifierNotifier(),
            new SnoreToastNotifier(),
            new ToasterNotifier(),
            new NotifySendNotifier(),
            new KDialogNotifier(),
        );
    }

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
