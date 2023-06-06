<?php

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
    public function __construct($preset, array $parameters = [])
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
