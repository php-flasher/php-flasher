<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Translation;

final class Language
{
    const LTR = 'ltr';
    const RTL = 'rtl';

    /**
     * @param string $locale
     *
     * @return string
     */
    public static function direction($locale)
    {
        if (!\extension_loaded('intl')) {
            return self::LTR;
        }

        $resource = \ResourceBundle::create($locale, 'ICUDATA', true);
        if (null === $resource) {
            return self::LTR;
        }

        $layout = $resource->get('layout');
        if (!$layout instanceof \ResourceBundle) {
            return self::LTR;
        }

        $characters = $layout->get('characters');
        if (!\is_string($characters)) {
            return self::LTR;
        }

        return 'right-to-left' === $characters ? self::RTL : self::LTR;
    }

    /**
     * @param string $locale
     *
     * @return bool
     */
    public static function isRTL($locale)
    {
        return self::RTL === self::direction($locale);
    }

    /**
     * @param string $locale
     *
     * @return bool
     */
    public static function isLTR($locale)
    {
        return self::LTR === self::direction($locale);
    }
}
