<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * PresetStamp - Associates a notification with a predefined template.
 *
 * This stamp identifies which preset template should be used for a notification.
 * Presets allow defining reusable notification templates with predefined types,
 * titles, messages, and options. The stamp can also include template parameters
 * for variable substitution.
 *
 * Design patterns:
 * - Template Reference: References a predefined template to use
 * - Parameter Carrier: Carries parameters for template variable substitution
 */
final readonly class PresetStamp implements StampInterface
{
    /**
     * Creates a new PresetStamp instance.
     *
     * @param string               $preset     The preset name to use
     * @param array<string, mixed> $parameters Template parameters for variable substitution
     */
    public function __construct(private string $preset, private array $parameters = [])
    {
    }

    /**
     * Gets the preset name.
     *
     * @return string The preset name
     */
    public function getPreset(): string
    {
        return $this->preset;
    }

    /**
     * Gets the template parameters.
     *
     * @return array<string, mixed> The template parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
