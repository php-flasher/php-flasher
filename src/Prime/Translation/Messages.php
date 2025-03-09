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
 * Messages - Registry of predefined translations for common notification messages.
 *
 * This class provides access to predefined translations for common notification
 * messages in multiple languages. It serves as a centralized registry of translations
 * that can be used without requiring an external translation service.
 *
 * Design patterns:
 * - Registry: Provides a centralized registry of translations
 * - Factory: Creates and returns language-specific translation sets
 * - Static Access: Provides static access to translation data
 */
final readonly class Messages
{
    /**
     * Gets translations for a specific language.
     *
     * This method returns a set of predefined translations for common notification
     * messages in the requested language. If the language is not supported, it
     * returns an empty array.
     *
     * @param string $language The language code (e.g., 'en', 'fr')
     *
     * @return array<string, string> Key-value pairs of message identifiers and translations
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
