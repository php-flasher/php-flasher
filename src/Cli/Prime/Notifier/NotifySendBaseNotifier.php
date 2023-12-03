<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class NotifySendBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('--urgency', 'normal')
            ->addOption('--app-name', 'notify')
            ->addOption('--icon', $notification->getIcon())
            ->addOption('--expire-time', 1)
            ->addArgument($notification->getTitle())
            ->addArgument($notification->getMessage());

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
        return 'notify-send';
    }
}
