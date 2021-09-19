<?php

namespace Flasher\Console\Prime;

use Flasher\Console\Prime\Notifier\NotifierInterface;
use Flasher\Console\Prime\Notifier\NullNotifier;

final class FlasherConsole
{
    /**
     * @var NotifierInterface[]
     */
    private $notifiers = array();

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
