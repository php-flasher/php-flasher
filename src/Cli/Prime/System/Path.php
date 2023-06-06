<?php

namespace Flasher\Cli\Prime\System;

final class Path
{
    /**
     * @param string $path
     *
     * @return string
     */
    public static function realpath($path)
    {
        return (string) realpath(str_replace(['/', '\\'], \DIRECTORY_SEPARATOR, $path));
    }
}
