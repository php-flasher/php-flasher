<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Translation;

use Flasher\Prime\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

final class Translator implements TranslatorInterface
{
    /**
     * @var SymfonyTranslatorInterface
     */
    private $translator;

    public function __construct(SymfonyTranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function translate($id, $locale = null)
    {
        return $this->translator->trans($id, array(), 'flasher', $locale);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocale()
    {
        return $this->translator->getLocale();
    }
}
