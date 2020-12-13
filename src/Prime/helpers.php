<?php

if (!function_exists('flasher_path')) {
    /**
     * normalize paths for linux and windows
     *
     * @param string $path
     *
     * @return string
     */
    function flasher_path($path = '')
    {
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    }
}
