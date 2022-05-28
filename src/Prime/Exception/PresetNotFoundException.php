<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Exception;

final class PresetNotFoundException extends \Exception
{
    /**
     * @param string   $preset
     * @param string[] $availablePresets
     */
    public function __construct($preset, array $availablePresets = array())
    {
        $message = sprintf('Preset "%s" not found, did you forget to register it?', $preset);
        if (array() !== $availablePresets) {
            $message .= sprintf(' Available presets: %s', implode(', ', $availablePresets));
        }

        parent::__construct($message);
    }
}
