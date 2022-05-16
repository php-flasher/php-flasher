<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        return OS::isWindowsSeven() && $this->getProgram();
    }

    /**
     * {@inheritdoc}
     */
    public function getBinary()
    {
        return 'notifu';
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryPaths()
    {
        return Path::realpath(__DIR__.'/../Resources/bin/notifu/notifu.exe');
    }
}
