<?php

use Flasher\Prime\Container\FlasherContainer;

if (!function_exists('notify')) {
    /**
     * @param Flasher\Cli\Prime\Notification|string|null $notification
     *
     * @return Flasher\Cli\Prime\Notify
     */
    function notify($notification = null)
    {
        /** @var Flasher\Cli\Prime\Notify $notifier */
        $notifier = FlasherContainer::create('flasher.notify');

        if (null === $notification || 0 === func_num_args()) {
            return $notifier;
        }

        $notifier->send($notification);

        return $notifier;
    }
}
