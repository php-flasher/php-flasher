<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class GrowlNotifyBaseNotifier extends BaseNotifier
{
    public function send($notification)
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('--message', $notification->getMessage())
            ->addOption('--title', $notification->getTitle())
            ->addOption('--image', $notification->getIcon());

        $cmd->run();
    }

    public function isSupported()
    {
        return OS::isMacOS() && $this->getProgram();
    }

    public function getBinary()
    {
        return 'growlnotify';
    }
}
