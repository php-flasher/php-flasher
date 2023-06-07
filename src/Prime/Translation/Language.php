<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

final class Language
{
    public const LTR = 'ltr';

    public const RTL = 'rtl';

    public static function direction(string $locale): string
    {
        if (! \extension_loaded('intl')) {
            return self::LTR;
        }

        $resource = \ResourceBundle::create($locale, 'ICUDATA', true);
        if (! $resource instanceof \ResourceBundle) {
            return self::LTR;
        }

        $layout = $resource->get('layout');
        if (! $layout instanceof \ResourceBundle) {
            return self::LTR;
        }

        $characters = $layout->get('characters');
        if (! \is_string($characters)) {
            return self::LTR;
        }

        return 'right-to-left' === $characters ? self::RTL : self::LTR;
    }

    public static function isRTL(string $locale): bool
    {
        return self::RTL === self::direction($locale);
    }

    public static function isLTR(string $locale): bool
    {
        return self::LTR === self::direction($locale);
    }
}
