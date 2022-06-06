<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Translation;

use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\TranslatorInterface;
use Illuminate\Translation\Translator as LaravelTranslator;

final class Translator implements TranslatorInterface
{
    /**
     * @var LaravelTranslator
     */
    private $translator;

    public function __construct(LaravelTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function translate($id, $parameters = array(), $locale = null)
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

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->translator->getLocale();
    }
}
