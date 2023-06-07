<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Cli\Prime\System\Path;

final class NotifuBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('/m', $notification->getMessage())
            ->addOption('/p', $notification->getTitle())
            ->addOption('/i', $notification->getIcon());

        $cmd->run();
    }

    public function isSupported(): bool
    {
        if (! OS::isWindowsSeven()) {
            return false;
        }

        return (bool) $this->getProgram();
    }

    public function getBinary(): string
    {
        return 'notifu';
    }

    public function getBinaryPaths(): string
    {
        return Path::realpath(__DIR__.'/../Resources/bin/notifu/notifu.exe');
    }
}
