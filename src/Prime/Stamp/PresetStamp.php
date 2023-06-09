<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class PresetStamp implements StampInterface
{
    /**
     * @param  array<string, mixed>  $parameters
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
     * @return array<string, mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
