<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\System;

final class OS
{
    public static function getName(): string
    {
        return php_uname('s');
    }

    public static function getRelease(): string
    {
        return php_uname('r');
    }

    public static function isUnix(): bool
    {
        return \in_array(self::getName(), [
            'Linux',
            'FreeBSD',
            'NetBSD',
            'OpenBSD',
            'SunOS',
            'DragonFly',
        ], true);
    }

    public static function isWindows(): bool
    {
        return 'WIN' === strtoupper(substr(self::getName(), 0, 3));
    }

    public static function isWindowsSeven(): bool
    {
        if (!self::isWindows()) {
            return false;
        }

        return '6.1' === self::getRelease();
    }

    public static function isWindowsEightOrHigher(): bool
    {
        if (!self::isWindows()) {
            return false;
        }

        return version_compare(self::getRelease(), '6.2', '>=');
    }

    public static function isWindowsSubsystemForLinux(): bool
    {
        if (!self::isUnix()) {
            return false;
        }

        return false !== mb_strpos(strtolower(self::getName()), 'microsoft');
    }

    public static function isMacOS(): bool
    {
        return str_contains(self::getName(), 'Darwin');
    }

    public static function getMacOSVersion(): string
    {
        exec('sw_vers -productVersion', $output);

        $output = (array) $output;

        return trim(reset($output));
    }
}
