<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

final class PresetStamp implements StampInterface
{
    /**
     * @var string
     */
    private $preset;

    /**
     * @var array<string, mixed>
     */
    private $parameters;

    /**
     * @param string               $preset
     * @param array<string, mixed> $parameters
     */
    public function __construct($preset, array $parameters = array())
    {
        $this->preset = $preset;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getPreset()
    {
        return $this->preset;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
