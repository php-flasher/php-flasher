<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Toastr\Prime\ToastrFactory;

if (!function_exists('toastr')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param string               $title
     * @param array<string, mixed> $options
     *
     * @return Envelope|ToastrFactory
     */
    function toastr($message = null, $type = NotificationInterface::SUCCESS, $title = '', array $options = array())
    {
        /** @var ToastrFactory $factory */
        $factory = FlasherContainer::create('flasher.toastr');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->title($title)->addFlash($type, $message, $options);
    }
}
