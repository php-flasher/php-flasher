<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\StampInterface;

if (!function_exists('flash')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     * @param StampInterface[]     $stamps
     *
     * @return Envelope|FlasherInterface
     */
    function flash($message = null, $type = 'success', array $options = array(), array $stamps = array())
    {
        /** @var FlasherInterface $factory */
        $factory = app('flasher');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->with($stamps)->addFlash($type, $message, $options);
    }
}

if (!function_exists('flasher')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     * @param StampInterface[]     $stamps
     *
     * @return Envelope|FlasherInterface
     */
    function flasher($message = null, $type = 'success', array $options = array(), array $stamps = array())
    {
        return flash($message, $type, $options, $stamps);
    }
}
