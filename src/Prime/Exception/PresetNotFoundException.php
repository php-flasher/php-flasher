<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

/**
 * PresetNotFoundException - Thrown when an unregistered notification preset is requested.
 *
 * This exception is thrown when attempting to use a notification preset that hasn't been
 * registered with the system. Presets define reusable notification templates that can be
 * referenced by name. The exception provides a clear error message that includes the requested
 * preset name and available presets for debugging purposes.
 *
 * Design pattern: Domain-specific exception - Provides contextual information about the error.
 */
final class PresetNotFoundException extends \Exception
{
    /**
     * Creates a new PresetNotFoundException with a descriptive message.
     *
     * @param string   $preset           The name of the preset that was not found
     * @param string[] $availablePresets The list of available presets for reference
     *
     * @return self The exception instance
     */
    public static function create(string $preset, array $availablePresets = []): self
    {
        $message = \sprintf('Preset "%s" not found, did you forget to register it?', $preset);

        if ([] !== $availablePresets) {
            $message .= \sprintf(' Available presets: "%s"', implode('", "', $availablePresets));
        }

        return new self($message);
    }
}
