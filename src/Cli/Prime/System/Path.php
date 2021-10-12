<?php

namespace Flasher\Cli\Prime\System;

class Path
{
    public static function realpath($path)
    {
        return realpath(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path));
    }
}
