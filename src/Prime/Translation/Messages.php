<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

use Flasher\Prime\Translation\Language\Arabic;
use Flasher\Prime\Translation\Language\Chinese;
use Flasher\Prime\Translation\Language\English;
use Flasher\Prime\Translation\Language\French;
use Flasher\Prime\Translation\Language\German;
use Flasher\Prime\Translation\Language\Portuguese;
use Flasher\Prime\Translation\Language\Russian;
use Flasher\Prime\Translation\Language\Spanish;

/**
 * This class provides a set of predefined message translations in various languages.
 * It holds arrays of key-value pairs where keys are message identifiers and values
 * are their respective translations.
 */
final readonly class Messages
{
    /**
     * @return array<string, string>
     */
    public static function get(string $language): array
    {
        return match ($language) {
            'ar' => Arabic::translations(),
            'de' => German::translations(),
            'en' => English::translations(),
            'es' => Spanish::translations(),
            'fr' => French::translations(),
            'pt' => Portuguese::translations(),
            'ru' => Russian::translations(),
            'zh' => Chinese::translations(),
            default => [],
        };
    }
}
