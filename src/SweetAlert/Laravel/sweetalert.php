<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\SweetAlert\Prime\SweetAlertFactory;

if (!function_exists('sweetalert')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|SweetAlertFactory
     */
    function sweetalert($message = null, $type = NotificationInterface::SUCCESS, array $options = array())
    {
        /** @var SweetAlertFactory $factory */
        $factory = app('flasher.sweetalert');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
