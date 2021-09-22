<?php

namespace Flasher\Console\Prime\System;

class Command
{
    private $command;
    private $options = array();
    private $arguments = array();
    private $output;
    private $exitCode;

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
        exec($this->command . ' ' . $this->formatOptions() . ' ' . $this->formatArguments(), $this->output, $this->exitCode);
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
                $line .= '='.$value.' ';
            }
        }

        return $line;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function isSuccessful()
    {
        return 0 === $this->getExitCode();
    }
}
