<?php

namespace Flasher\Cli\Prime\System;

final class OS
{
    /**
     * @return string
     */
    public static function getName()
    {
        return php_uname('s');
    }

    /**
     * @return string
     */
    public static function getRelease()
    {
        return php_uname('r');
    }

    /**
     * @return bool
     */
    public static function isUnix()
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

    /**
     * @return bool
     */
    public static function isWindows()
    {
        return 'WIN' === strtoupper(substr(self::getName(), 0, 3));
    }

    /**
     * @return bool
     */
    public static function isWindowsSeven()
    {
        return self::isWindows() && '6.1' === self::getRelease();
    }

    /**
     * @return bool
     */
    public static function isWindowsEightOrHigher()
    {
        return self::isWindows() && version_compare(self::getRelease(), '6.2', '>=');
    }

    /**
     * @return bool
     */
    public static function isWindowsSubsystemForLinux()
    {
        return self::isUnix() && false !== mb_strpos(strtolower(self::getName()), 'microsoft');
    }

    /**
     * @return bool
     */
    public static function isMacOS()
    {
        return str_contains(self::getName(), 'Darwin');
    }

    /**
     * @return string
     */
    public static function getMacOSVersion()
    {
        exec('sw_vers -productVersion', $output);

        $output = (array) $output;

        return trim(reset($output));
    }
}
