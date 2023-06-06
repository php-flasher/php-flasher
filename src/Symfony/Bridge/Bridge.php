<?php

namespace Flasher\Symfony\Bridge;

use Symfony\Component\HttpKernel\Kernel;

final class Bridge
{
    /**
     * @return bool
     */
    public static function isLegacy()
    {
        return self::versionCompare('6', '<');
    }

    /**
     * @param string $version
     * @param string $operator
     *
     * @return bool
     */
    public static function versionCompare($version, $operator = '=')
    {
        return version_compare(Kernel::VERSION, $version, $operator);
    }

    /**
     * @return bool
     */
    public static function canLoadAliases()
    {
        return self::versionCompare('3.0', '>=');
    }
}
