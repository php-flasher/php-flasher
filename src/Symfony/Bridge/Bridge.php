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
        return Kernel::MAJOR_VERSION < 6;
    }

    /**
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
