<?php

namespace Flasher\Cli\Prime\System;

class OS
{
    public static function getName()
    {
        return php_uname('s');
    }

    public static function getRelease()
    {
        return php_uname('r');
    }

    public static function isUnix()
    {
        return in_array(self::getName(), array(
            'Linux',
            'FreeBSD',
            'NetBSD',
            'OpenBSD',
            'SunOS',
            'DragonFly',
        ));
    }

    public static function isWindows()
    {
        return 'WIN' === strtoupper(substr(self::getName(), 0, 3));
    }

    public static function isWindowsSeven()
    {
        return self::isWindows() && '6.1' === self::getRelease();
    }

    public static function isWindowsEightOrHigher()
    {
        return self::isWindows() && version_compare(self::getRelease(), '6.2', '>=');
    }

    public static function isWindowsSubsystemForLinux()
    {
        return self::isUnix() && false !== mb_strpos(strtolower(self::getName()), 'microsoft');
    }

    public static function isMacOS()
    {
        return false !== strpos(self::getName(), 'Darwin');
    }

    public static function getMacOSVersion()
    {
        exec('sw_vers -productVersion', $output);

        return trim($output);
    }
}
