<?php

declare(strict_types=1);

namespace Flasher\Laravel\Translation;

use Flasher\Prime\Translation\TranslatorInterface;
use Illuminate\Translation\Translator as LaravelTranslator;

/**
 * Translator - Laravel adapter for PHPFlasher translations.
 *
 * This class provides an implementation of PHPFlasher's translator interface
 * using Laravel's translation system. It enables PHPFlasher notifications
 * to be localized using Laravel's language files and translation workflow.
 *
 * Design patterns:
 * - Adapter: Adapts Laravel's translator to PHPFlasher's interface
 * - Decorator: Adds PHPFlasher-specific behavior to Laravel's translator
 */
final readonly class Translator implements TranslatorInterface
{
    /**
     * Creates a new Translator instance.
     *
     * @param LaravelTranslator $translator Laravel's translator service
     */
    public function __construct(private LaravelTranslator $translator)
    {
    }

    /**
     * {@inheritdoc}
     *
     * Translates a message using Laravel's translation system.
     * Tries multiple namespaces in this order:
     * 1. flasher::messages.{id}
     * 2. messages.{id}
     * 3. {id} directly
     *
     * @param string               $id         The translation key
     * @param array<string, mixed> $parameters The parameters for variable substitution
     * @param string|null          $locale     The locale to use, or null for default
     *
     * @return string The translated string
     */
    public function translate(string $id, array $parameters = [], ?string $locale = null): string
    {
        $parameters = $this->formatParameters($parameters);

        $translation = $this->translator->has('flasher::messages.'.$id, $locale)
            ? $this->translator->get('flasher::messages.'.$id, $parameters, $locale)
            : ($this->translator->has('messages.'.$id, $locale)
                ? $this->translator->get('messages.'.$id, $parameters, $locale)
                : $this->translator->get($id, $parameters, $locale));

        if (!\is_string($translation)) {
            return $id;
        }

        return $translation;
    }

    /**
     * {@inheritdoc}
     *
     * Gets the current locale from Laravel's translator.
     *
     * @return string The current locale code
     */
    public function getLocale(): string
    {
        return $this->translator->getLocale();
    }

    /**
     * Formats the parameters by stripping the colon prefix from keys for Laravel's translator.
     *
     * This ensures compatibility between PHPFlasher's parameter format (:parameter)
     * and Laravel's parameter format (parameter).
     *
     * @param array<string, mixed> $parameters The parameters with potential colon prefixes
     *
     * @return array<string, mixed> The formatted parameters
     */
    private function formatParameters(array $parameters): array
    {
        foreach ($parameters as $key => $value) {
            $parameters[ltrim($key, ':')] = $value;
        }

        return $parameters;
    }
}
