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
     * @param string $preset
     */
    public function __construct($preset)
    {
        $this->preset = $preset;
    }

    /**
     * @return string
     */
    public function getPreset()
    {
        return $this->preset;
    }
}
