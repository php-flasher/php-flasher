<?php

namespace Flasher\Console\Prime;

use Flasher\Console\Prime\Notifier\GrowlNotifyNotifier;
use Flasher\Console\Prime\Notifier\KDialogNotifier;
use Flasher\Console\Prime\Notifier\NotifierInterface;
use Flasher\Console\Prime\Notifier\NotifuNotifier;
use Flasher\Console\Prime\Notifier\NotifySendNotifier;
use Flasher\Console\Prime\Notifier\NullNotifier;
use Flasher\Console\Prime\Notifier\SnoreToastNotifier;
use Flasher\Console\Prime\Notifier\TerminalNotifierNotifier;
use Flasher\Console\Prime\Notifier\ToasterNotifier;

final class FlasherConsole
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

    public function render(array $envelopes)
    {
        $notifier = $this->createNotifier();

        $notifier->render($envelopes);
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
