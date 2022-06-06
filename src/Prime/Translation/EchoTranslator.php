<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Translation;

final class EchoTranslator implements TranslatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function translate($id, $parameters = array(), $locale = null)
    {
        return $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getLocale()
    {
        return 'en';
    }
}
