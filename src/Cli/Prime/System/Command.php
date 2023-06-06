<?php

namespace Flasher\Cli\Prime\System;

final class Command
{
    /**
     * @var string|null
     */
    private $command;

    /**
     * @var array<string, int|string|null>
     */
    private $options = [];

    /**
     * @var array<int|string|null>
     */
    private $arguments = [];

    /**
     * @param string|null $command
     */
    public function __construct($command)
    {
        $this->command = null !== $command ? escapeshellcmd((string) $command) : null;
    }

    /**
     * @param string          $name
     * @param int|string|null $value
     *
     * @return static
     */
    public function addOption($name, $value = null)
    {
        $this->options[$name] = null !== $value ? escapeshellarg((string) $value) : null;

        return $this;
    }

    /**
     * @param int|string|null $argument
     *
     * @return static
     */
    public function addArgument($argument)
    {
        $this->arguments[] = null !== $argument ? escapeshellarg((string) $argument) : $argument;

        return $this;
    }

    /**
     * @return void
     */
    public function run()
    {
        $command = $this->command.' '.$this->formatOptions().' '.$this->formatArguments();

        if (OS::isWindows()) {
            pclose(popen('start /B '.$command, 'r')); // @phpstan-ignore-line

            return;
        }

        exec($command);
    }

    /**
     * @return string
     */
    private function formatArguments()
    {
        return implode(' ', $this->arguments);
    }

    /**
     * @return string
     */
    private function formatOptions()
    {
        $line = '';

        foreach ($this->options as $name => $value) {
            $line .= $name;
            if ($value) {
                $line .= ' '.$value.' ';
            }
        }

        return $line;
    }
}
