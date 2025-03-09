<?php

declare(strict_types=1);

namespace Flasher\Symfony\Translation;

use Flasher\Prime\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

/**
 * Translator - Adapter for Symfony's translation service.
 *
 * This class adapts Symfony's translation system to PHPFlasher's TranslatorInterface,
 * enabling notification messages to be translated using Symfony's translation capabilities.
 * It searches for messages in multiple domains with cascading fallbacks.
 *
 * Design patterns:
 * - Adapter Pattern: Adapts Symfony's translator interface to PHPFlasher's interface
 * - Facade Pattern: Simplifies the translation process with a unified interface
 * - Chain of Responsibility: Tries multiple translation domains in sequence
 */
final readonly class Translator implements TranslatorInterface
{
    /**
     * Creates a new Translator instance.
     *
     * @param SymfonyTranslatorInterface $translator The Symfony translator service
     */
    public function __construct(private SymfonyTranslatorInterface $translator)
    {
    }

    /**
     * Translates a message using Symfony's translation system.
     *
     * This method attempts to translate the message in the following order:
     * 1. In the 'flasher' domain (flasher-specific translations)
     * 2. In the 'messages' domain (application-wide translations)
     * 3. Returns the original ID if no translation is found
     *
     * @param string               $id         The message ID or key
     * @param array<string, mixed> $parameters The translation parameters
     * @param string|null          $locale     The locale or null to use the default
     *
     * @return string The translated string
     */
    public function translate(string $id, array $parameters = [], ?string $locale = null): string
    {
        if (!$this->translator instanceof TranslatorBagInterface) {
            return $this->translator->trans($id, $parameters, 'flasher', $locale);
        }

        $catalogue = $this->translator->getCatalogue($locale);

        foreach (['flasher', 'messages'] as $domain) {
            if ($catalogue->has($id, $domain)) {
                return $this->translator->trans($id, $parameters, $domain, $locale);
            }
        }

        return $id;
    }

    /**
     * Gets the current locale from Symfony's translator.
     *
     * Falls back to system default locale if translator doesn't provide one.
     *
     * @return string The current locale code
     */
    public function getLocale(): string
    {
        if (method_exists($this->translator, 'getLocale')) { // @phpstan-ignore-line
            return $this->translator->getLocale();
        }

        return class_exists(\Locale::class) ? \Locale::getDefault() : 'en';
    }
}
