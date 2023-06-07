<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\System;

final class Path
{
    /**
     * @param  string  $path
     */
    public static function realpath($path): string
    {
        return (string) realpath(str_replace(['/', '\\'], \DIRECTORY_SEPARATOR, $path));
    }
}
