<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

final class PresetNotFoundException extends \Exception
{
    /**
     * @param string[] $availablePresets
     */
    public static function create(string $preset, array $availablePresets = []): self
    {
        $message = \sprintf('Preset "%s" not found, did you forget to register it?', $preset);

        if ([] !== $availablePresets) {
            $message .= \sprintf(' Available presets: [%s]', implode(', ', $availablePresets));
        }

        return new self($message);
    }
}
