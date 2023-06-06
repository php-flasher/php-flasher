<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class NotifySendBaseNotifier extends BaseNotifier
{
    public function send($notification)
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

    public function isSupported()
    {
        return OS::isUnix() && $this->getProgram();
    }

    public function getBinary()
    {
        return 'notify-send';
    }
}
