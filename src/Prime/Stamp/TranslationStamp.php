<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * TranslationStamp - Provides translation parameters and locale for a notification.
 *
 * This stamp contains translation parameters and an optional locale override
 * for translating notification content. It allows for customization of how
 * notification titles and messages are translated.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Parameter Carrier: Carries parameters for translation processing
 */
final readonly class TranslationStamp implements StampInterface
{
    /**
     * Creates a new TranslationStamp instance.
     *
     * @param array<string, mixed> $parameters Translation parameters for variable substitution
     * @param string|null          $locale     Locale override (null uses default locale)
     */
    public function __construct(private array $parameters = [], private ?string $locale = null)
    {
    }

    /**
     * Gets the translation parameters.
     *
     * @return array<string, mixed> The translation parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Gets the locale override.
     *
     * @return string|null The locale override, or null to use default locale
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
