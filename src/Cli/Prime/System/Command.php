<?php

namespace Flasher\Cli\Prime\System;

class Command
{
    private $command;
    private $options = array();
    private $arguments = array();

    public function __construct($command)
    {
        $this->command = escapeshellcmd($command);
    }

    public function addOption($name, $value = null)
    {
        $this->options[$name] = escapeshellarg($value);

        return $this;
    }

    public function addArgument($argument)
    {
        $this->arguments[] = escapeshellarg($argument);

        return $this;
    }

    public function run()
    {
        $command = $this->command.' '.$this->formatOptions().' '.$this->formatArguments();

        if (OS::isWindows()) {
            pclose(popen("start /B ".$command, "r"));

            return;
        }

        exec($command);
    }

    private function formatArguments()
    {
        return implode(' ', $this->arguments);
    }

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
