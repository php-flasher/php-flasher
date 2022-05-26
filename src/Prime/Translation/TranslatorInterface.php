<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Translation;

interface TranslatorInterface
{
    /**
     * @param string      $id
     * @param string|null $locale
     *
     * @return string
     */
    public function translate($id, $locale = null);

    /**
     * @return string
     */
    public function getLocale();
}
