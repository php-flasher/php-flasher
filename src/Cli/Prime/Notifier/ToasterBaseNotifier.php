<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Cli\Prime\System\Path;

final class ToasterBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('-t', $notification->getTitle())
            ->addOption('-m', $notification->getMessage())
            ->addOption('-p', $notification->getIcon())
            ->addArgument('-w');

        $cmd->run();
    }

    public function isSupported(): bool
    {
        if (!$this->getProgram()) {
            return false;
        }

        if (OS::isWindowsEightOrHigher()) {
            return true;
        }

        return OS::isWindowsSubsystemForLinux();
    }

    public function getBinary(): string
    {
        return 'toast';
    }

    public function getBinaryPaths(): string
    {
        return Path::realpath(__DIR__.'/../Resources/bin/toaster/toast.exe');
    }
}
