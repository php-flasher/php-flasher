<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

final class TranslationStamp implements StampInterface
{
    /**
     * @var string|null
     */
    private $locale;

    /**
     * @param string|null $locale
     */
    public function __construct($locale = null)
    {
        $this->locale = $locale;
    }

    /**
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
