<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class KDialogBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('--passivepopup', $notification->getMessage())
            ->addOption('--title', $notification->getTitle())
            ->addArgument(5);

        $cmd->run();
    }

    public function isSupported(): bool
    {
        if (!OS::isUnix()) {
            return false;
        }

        return (bool) $this->getProgram();
    }

    public function getBinary(): string
    {
        return 'kdialog';
    }
}
