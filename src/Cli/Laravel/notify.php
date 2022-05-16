<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

if (!function_exists('notify')) {
    /**
     * @param Flasher\Cli\Prime\Notification|string|null $notification
     *
     * @return Flasher\Cli\Prime\Notify
     */
    function notify($notification = null)
    {
        /** @var Flasher\Cli\Prime\Notify $notifier */
        $notifier = app('flasher.notify');

        if (null === $notification || 0 === func_num_args()) {
            return $notifier;
        }

        $notifier->send($notification);

        return $notifier;
    }
}
