<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

/**
 * Language - Utility class for determining text direction based on locale.
 *
 * This class provides static methods for working with language directionality,
 * particularly for determining if a language uses left-to-right (LTR) or
 * right-to-left (RTL) text direction.
 *
 * Design patterns:
 * - Utility: Provides a collection of static methods for a specific purpose
 * - Service: Provides functionality related to a specific domain concept
 */
final readonly class Language
{
    /**
     * Constant representing left-to-right text direction.
     */
    public const LTR = 'ltr';

    /**
     * Constant representing right-to-left text direction.
     */
    public const RTL = 'rtl';

    /**
     * Determines the text direction for a given locale.
     *
     * This method uses the PHP intl extension to access ICU data about text direction.
     * If the extension is not available or the locale data is missing, it defaults to LTR.
     *
     * @param string $locale The locale code to check (e.g., 'en', 'ar')
     *
     * @return string Either 'ltr' for left-to-right or 'rtl' for right-to-left
     */
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
