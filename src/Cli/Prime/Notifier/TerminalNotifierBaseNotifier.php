<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class TerminalNotifierBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('-message', $notification->getMessage())
            ->addOption('-title', $notification->getTitle());

        if (version_compare(OS::getMacOSVersion(), '10.9.0', '>=')) {
            $cmd->addOption('-appIcon', $notification->getIcon());
        }

        /** @var string|null $url */
        $url = $notification->getOption('url');
        if ($url) {
            $cmd->addOption('-open', $url);
        }

        $cmd->run();
    }

    public function isSupported(): bool
    {
        if (! OS::isMacOS()) {
            return false;
        }

        return (bool) $this->getProgram();
    }

    public function getBinary(): string
    {
        return 'terminal-notifier';
    }
}
