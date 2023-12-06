<?php

declare(strict_types=1);

namespace Flasher\Laravel\Translation;

use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\TranslatorInterface;
use Illuminate\Translation\Translator as LaravelTranslator;

final class Translator implements TranslatorInterface
{
    public function __construct(private readonly LaravelTranslator $translator)
    {
    }

    public function translate($id, $parameters = [], $locale = null): string
    {
        $order = TranslationStamp::parametersOrder($parameters, $locale);
        $parameters = $order['parameters'];
        $locale = $order['locale'];

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
}
