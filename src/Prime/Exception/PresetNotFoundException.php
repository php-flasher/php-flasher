<?php

namespace Flasher\Prime\Exception;

final class PresetNotFoundException extends \Exception
{
    /**
     * @param string[] $availablePresets
     */
    public function __construct(string $preset, array $availablePresets = [])
    {
        $message = sprintf('Preset "%s" not found, did you forget to register it?', $preset);
        if ([] !== $availablePresets) {
            $message .= sprintf(' Available presets: %s', implode(', ', $availablePresets));
        }

        parent::__construct($message);
    }
}
