<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class Chinese
{
    /**
     * Chinese (Mandarin) translations.
     *
     * @return array<string, string> array of message keys and their Chinese translations
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
