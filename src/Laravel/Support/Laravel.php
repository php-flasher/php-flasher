<?php

declare(strict_types=1);

namespace Flasher\Laravel\Support;

use Illuminate\Foundation\Application;

final class Laravel
{
    /**
     * @param  string  $version
     * @param  string|null  $operator
     * @return bool
     */
    public static function isVersion($version, $operator = null)
    {
        if (null !== $operator) {
            return version_compare(Application::VERSION, $version, $operator);
        }

        $parts = explode('.', $version);
        $parts[\count($parts) - 1]++;
        $next = implode('.', $parts);
        if (! self::isVersion($version, '>=')) {
            return false;
        }

        return self::isVersion($next, '<');
    }
}
