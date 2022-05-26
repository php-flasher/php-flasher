<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Translation;

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
    public function translate($id, $locale = null)
    {
        $translation = $this->translator->has('flasher::messages.'.$id, $locale)
            ? $this->translator->get('flasher::messages.'.$id, array(), $locale)
            : $this->translator->get($id, array(), $locale);

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
