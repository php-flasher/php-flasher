<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Cli\Prime\System\Path;

final class SnoreToastBaseNotifier extends BaseNotifier
{
    public function send($notification)
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('-m', $notification->getMessage())
            ->addOption('-t', $notification->getTitle())
            ->addOption('-p', $notification->getIcon());

        $cmd->run();
    }

    public function isSupported()
    {
        if (!$this->getProgram()) {
            return false;
        }

        return OS::isWindowsEightOrHigher() || OS::isWindowsSubsystemForLinux();
    }

    public function getBinary()
    {
        return 'snoretoast';
    }

    public function getBinaryPaths()
    {
        return Path::realpath(__DIR__.'/../Resources/bin/snoreToast/snoretoast-x86.exe');
    }
}
