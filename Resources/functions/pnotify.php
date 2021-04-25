<?php

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\App;

if (! function_exists('pnotify'))  {
    /**
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return \Flasher\Pnotify\Prime\PnotifyFactory
     */
    function pnotify($message = null, $type = NotificationInterface::TYPE_SUCCESS, array $options = array())
    {
        if (null === $message) {
            return App::make('flasher.pnotify');
        }

        return App::make('flasher.pnotify')->addFlash($type, $message, $options);
    }
}