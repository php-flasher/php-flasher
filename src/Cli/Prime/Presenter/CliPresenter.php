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

    /**
     * @var NotifierInterface[]
     */
    private $sorted = array();

    public function render(Response $response)
    {
        if (0 === count($response->getEnvelopes())) {
            return;
        }

        $notifier = $this->createNotifier();

        $notifier->render($response->getEnvelopes());
    }

    public function addNotifier(NotifierInterface $notifier)
    {
        $this->notifiers[] = $notifier;
    }

    public function getSortedNotifiers()
    {
        if (0 !== count($this->sorted)) {
            return $this->sorted;
        }

        $this->sorted = $this->notifiers;

        usort($this->sorted, static function (NotifierInterface $a, NotifierInterface $b) {
            $priorityA = $a->getPriority();
            $priorityB = $b->getPriority();

            if ($priorityA == $priorityB) {
                return 0;
            }

            return $priorityA < $priorityB ? 1 : -1;
        });

        return $this->sorted;
    }

    /**
     * @return NotifierInterface
     */
    private function createNotifier()
    {
        foreach ($this->getSortedNotifiers() as $notifier) {
            if ($notifier->isSupported()) {
                return $notifier;
            }
        }

        return new NullNotifier();
    }
}
