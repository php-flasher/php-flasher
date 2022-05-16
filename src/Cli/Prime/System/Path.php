<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
        return (string) realpath(str_replace(array('/', '\\'), \DIRECTORY_SEPARATOR, $path));
    }
}
