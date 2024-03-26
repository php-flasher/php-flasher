<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\Chinese;
use PHPUnit\Framework\TestCase;

final class ChineseTest extends TestCase
{
    /**
     * Function to test the translations method of the Chinese class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
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

        $this->assertSame($expectedTranslations, Chinese::translations());
    }
}
