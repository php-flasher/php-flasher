<?php

namespace Flasher\Cli\Prime\System;

class Program
{
    public static function exist($program)
    {
        if (OS::isWindows()) {
            $output = shell_exec("where $program 2>null");

            return !empty($output);
        }

        $output = shell_exec("command -v $program");

        return !empty($output);
    }
}
