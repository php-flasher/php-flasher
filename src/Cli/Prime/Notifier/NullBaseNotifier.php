<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime\Notifier;

final class NullBaseNotifier extends BaseNotifier
{
    /**
     * {@inheritdoc}
     */
    public function send($notification)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getBinary()
    {
        return '';
    }
}
