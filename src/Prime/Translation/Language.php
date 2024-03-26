<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

/**
 * Provides utilities for determining the text direction (Left-to-Right or Right-to-Left)
 * based on a given locale. This can be particularly useful for handling languages
 * with different writing directions in internationalized applications.
 */
final readonly class Language
{
    public const LTR = 'ltr';

    public const RTL = 'rtl';

    /**
     * Determines the text direction for a given locale.
     *
     * It uses the 'intl' PHP extension to get text direction from the ICU data.
     * Defaults to Left-to-Right (LTR) if the 'intl' extension is not available,
     * the locale is not found, or the text direction data is not available.
     *
     * @param string $locale the locale to check the text direction for
     *
     * @return string returns 'ltr' for Left-to-Right or 'rtl' for Right-to-Left text direction
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
     * Checks if the given locale is Right-to-Left (RTL).
     *
     * @param string $locale the locale to check
     *
     * @return bool returns true if the locale is RTL, false otherwise
     */
    public static function isRTL(string $locale): bool
    {
        return self::RTL === self::direction($locale);
    }

    /**
     * Checks if the given locale is Left-to-Right (LTR).
     *
     * @param string $locale the locale to check
     *
     * @return bool returns true if the locale is LTR, false otherwise
     */
    public static function isLTR(string $locale): bool
    {
        return self::LTR === self::direction($locale);
    }
}
