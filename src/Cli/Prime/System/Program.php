<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\System;

final class Program
{
    /**
     * @param  string|null  $program
     * @return bool
     */
    public static function exist($program)
    {
        if (null === $program) {
            return false;
        }

        if (OS::isWindows()) {
            $output = shell_exec(sprintf('where %s 2>null', $program));

            return ! ('' === $output || false === $output || null === $output);
        }

        $output = shell_exec(sprintf('command -v %s', $program));

        return ! ('' === $output || false === $output || null === $output);
    }
}
