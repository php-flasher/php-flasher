<?php

declare(strict_types=1);

namespace Flasher\Laravel\Translation;

use Flasher\Prime\Translation\TranslatorInterface;
use Illuminate\Translation\Translator as LaravelTranslator;

final readonly class Translator implements TranslatorInterface
{
    public function __construct(private LaravelTranslator $translator)
    {
    }

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

    public function getLocale(): string
    {
        return $this->translator->getLocale();
    }

    /**
     * Formats the parameters by stripping the colon prefix from keys for Laravel's translator.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    private function formatParameters(array $parameters): array
    {
        foreach ($parameters as $key => $value) {
            $parameters[ltrim($key, ':')] = $value;
        }

        return $parameters;
    }
}
