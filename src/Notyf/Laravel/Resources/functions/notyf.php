<?php

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\App;

if (! function_exists('notyf'))  {
    /**
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return \Flasher\Notyf\Prime\NotyfFactory
     */
    function notyf($message = null, $type = NotificationInterface::TYPE_SUCCESS, array $options = array())
    {
        if (null === $message) {
            return App::make('flasher.notyf');
        }

        return App::make('flasher.notyf')->addFlash($type, $message, $options);
    }
}