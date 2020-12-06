<?php

if (!function_exists('notify')) {
    /**
     * @param string $message
     * @param string $type
     * @param string $title
     * @param array  $options
     * @param array  $stamps
     *
     * @return \Flasher\Prime\Flasher
     */
    function notify($message = null, $type = 'success', $title = '', array $options = array(), array $stamps = array())
    {
        if (is_null($message) && 0 === func_num_args()) {
            return app('flasher.factory');
        }

        return app('flasher.factory')->render($type, $message, $title, $options, $stamps);
    }
}
