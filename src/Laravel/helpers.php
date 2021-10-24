<?php

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Stamp\StampInterface;

if (!function_exists('flash')) {
    /**
     * @param string $message
     * @param string $type
     * @param array<string, mixed> $options
     * @param StampInterface[] $stamps
     *
     * @return FlasherInterface
     */
    function flash($message = null, $type = 'success', array $options = array(), array $stamps = array())
    {
        $flasher = app('flasher');

        if (null === $message && 0 === func_num_args()) {
            return $flasher;
        }

        return $flasher->with($stamps)->addFlash($type, $message, $options);
    }
}

if (!function_exists('flasher')) {
    /**
     * @param string $message
     * @param string $type
     * @param array<string, mixed> $options
     * @param StampInterface[] $stamps
     *
     * @return FlasherInterface
     */
    function flasher($message = null, $type = 'success', array $options = array(), array $stamps = array())
    {
        return flash($message, $type, $options, $stamps);
    }
}
