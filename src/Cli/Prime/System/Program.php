<?php

namespace Flasher\Cli\Prime\System;

final class Program
{
    /**
     * @param string|null $program
     *
     * @return bool
     */
    public static function exist($program)
    {
        if (null === $program) {
            return false;
        }

        if (OS::isWindows()) {
            $output = shell_exec("where {$program} 2>null");

            return !empty($output);
        }

        $output = shell_exec("command -v {$program}");

        return !empty($output);
    }
}
