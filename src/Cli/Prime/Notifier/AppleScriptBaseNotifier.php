<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class AppleScriptBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addArgument(sprintf('display notification "%s"', $notification->getMessage()))
            ->addArgument(sprintf('with title "%s"', $notification->getTitle()));

        /** @var string $subtitle */
        $subtitle = $notification->getOption('subtitle');
        if ('' !== $subtitle && '0' !== $subtitle) {
            $cmd->addArgument(sprintf('subtitle "%s"', $subtitle));
        }

        $cmd->run();
    }

    public function isSupported(): bool
    {
        if (!$this->getProgram()) {
            return false;
        }

        if (!OS::isMacOS()) {
            return false;
        }

        return version_compare(OS::getMacOSVersion(), '10.9.0', '>=');
    }

    public function getBinary(): string
    {
        return 'osascript';
    }
}
