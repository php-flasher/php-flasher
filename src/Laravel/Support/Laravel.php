<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Support;

use Illuminate\Foundation\Application;

final class Laravel
{
    /**
     * @param string      $version
     * @param string|null $operator
     *
     * @return bool
     */
    public static function isVersion($version, $operator = null)
    {
        if (null !== $operator) {
            return version_compare(Application::VERSION, $version, $operator);
        }

        $parts = explode('.', $version);
        ++$parts[\count($parts) - 1];
        $next = implode('.', $parts);

        return self::isVersion($version, '>=') && self::isVersion($next, '<');
    }
}
