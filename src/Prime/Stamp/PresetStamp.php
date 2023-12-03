<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class PresetStamp implements StampInterface
{
    /**
     * @param array<string, string> $parameters
     */
    public function __construct(
        private readonly string $preset,
        private readonly array $parameters = [],
    ) {
    }

    public function getPreset(): string
    {
        return $this->preset;
    }

    /**
     * @return array<string, string>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
