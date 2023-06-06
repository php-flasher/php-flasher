<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Cli\Prime\System\Path;

final class NotifuBaseNotifier extends BaseNotifier
{
    public function send($notification)
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('/m', $notification->getMessage())
            ->addOption('/p', $notification->getTitle())
            ->addOption('/i', $notification->getIcon());

        $cmd->run();
    }

    public function isSupported()
    {
        return OS::isWindowsSeven() && $this->getProgram();
    }

    public function getBinary()
    {
        return 'notifu';
    }

    public function getBinaryPaths()
    {
        return Path::realpath(__DIR__.'/../Resources/bin/notifu/notifu.exe');
    }
}
