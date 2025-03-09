<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * Chinese - Provides Mandarin Chinese translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in Mandarin Chinese. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class Chinese
{
    /**
     * Provides Chinese translations for common notification messages.
     *
     * The returned array maps message identifiers to their Chinese translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => '成功',
            'error' => '错误',
            'warning' => '警告',
            'info' => '信息',

            'The resource was created' => ':resource 已创建',
            'The resource was updated' => ':resource 已更新',
            'The resource was saved' => ':resource 已保存',
            'The resource was deleted' => ':resource 已删除',

            'resource' => '资源',
        ];
    }
}
