<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class ZenityBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addArgument('--notification')
            ->addOption('--text', $notification->getTitle().'\n\n'.$notification->getMessage())
            ->addOption('--window-icon', $notification->getIcon());

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
        return 'zenity';
    }
}
