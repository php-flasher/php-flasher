<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class TranslationStamp implements StampInterface
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function __construct(private array $parameters = [], private ?string $locale = null)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
