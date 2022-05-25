<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Translation;

final class EchoTranslator implements TranslatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function translate($id, $locale = null)
    {
        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return 'en';
    }
}
