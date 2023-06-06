<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;

final class AppleScriptBaseNotifier extends BaseNotifier
{
    public function send($notification)
    {
        $notification = Notification::wrap($notification);

        $cmd = new Command($this->getProgram());

        $cmd
            ->addArgument(sprintf('display notification "%s"', $notification->getMessage()))
            ->addArgument(sprintf('with title "%s"', $notification->getTitle()));

        /** @var string $subtitle */
        $subtitle = $notification->getOption('subtitle');
        if ($subtitle) {
            $cmd->addArgument(sprintf('subtitle "%s"', $subtitle));
        }

        $cmd->run();
    }

    public function isSupported()
    {
        if (!$this->getProgram()) {
            return false;
        }

        return OS::isMacOS() && version_compare(OS::getMacOSVersion(), '10.9.0', '>=');
    }

    public function getBinary()
    {
        return 'osascript';
    }
}
