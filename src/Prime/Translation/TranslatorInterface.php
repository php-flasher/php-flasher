<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Translation;

interface TranslatorInterface
{
    /**
     * @param string               $id
     * @param array<string, mixed> $parameters
     * @param string|null          $locale
     *
     * @return string
     */
    public function translate($id, $parameters = array(), $locale = null);

    /**
     * @return string
     */
    public function getLocale();
}
