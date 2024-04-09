<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\Language;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LanguageTest extends TestCase
{
    #[DataProvider('provideLocaleData')]
    public function testDirectionMethod(string $locale, string $expectedDirection): void
    {
        $this->assertSame($expectedDirection, Language::direction($locale));
    }

    /**
     * Provide test cases for testDirectionMethod.
     */
    public static function provideLocaleData(): \Iterator
    {
        yield ['en', Language::LTR];
        yield ['ar', Language::RTL];
        yield ['unknown', Language::LTR];
    }

    #[DataProvider('provideLocaleDataForIsRTL')]
    public function testIsRTLMethod(string $locale, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, Language::isRTL($locale));
    }

    /**
     * Provide test cases for testIsRTLMethod.
     */
    public static function provideLocaleDataForIsRTL(): \Iterator
    {
        yield ['en', false];
        yield ['en_US', false];
        yield ['ar', true];
    }

    #[DataProvider('provideLocaleDataForIsLTR')]
    public function testIsLTRMethod(string $locale, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, Language::isLTR($locale));
    }

    /**
     * Provide test cases for testIsLTRMethod.
     */
    public static function provideLocaleDataForIsLTR(): \Iterator
    {
        yield ['en', true];
        yield ['ar', false];
    }
}
