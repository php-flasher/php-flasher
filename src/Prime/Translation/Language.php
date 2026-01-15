<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

final readonly class Language
{
    public const LTR = 'ltr';
    public const RTL = 'rtl';

    public static function direction(string $locale): string
    {
        if (!\extension_loaded('intl')) {
            return self::LTR;
        }

        $resource = \ResourceBundle::create($locale, 'ICUDATA', false);
        $layout = $resource?->get('layout');

        if (!$layout instanceof \ResourceBundle) {
            return self::LTR;
        }

        return 'right-to-left' === $layout->get('characters') ? self::RTL : self::LTR;
    }

    /**
     * Checks if the given locale uses right-to-left text direction.
     *
     * @param string $locale The locale code to check
     *
     * @return bool True if the locale uses RTL, false otherwise
     */
    public static function isRTL(string $locale): bool
    {
        return self::RTL === self::direction($locale);
    }

    /**
     * Checks if the given locale uses left-to-right text direction.
     *
     * @param string $locale The locale code to check
     *
     * @return bool True if the locale uses LTR, false otherwise
     */
    public static function isLTR(string $locale): bool
    {
        return self::LTR === self::direction($locale);
    }
}
