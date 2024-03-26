<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\Messages;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MessagesTest extends TestCase
{
    /**
     * Test 'get' method with provided languages.
     */
    #[DataProvider('provideLanguages')]
    public function testGet(string $language, bool $empty): void
    {
        $actual = Messages::get($language);
        $this->assertIsArray($actual);
        $this->assertSame($empty, empty($actual));
    }

    public static function provideLanguages(): \Iterator
    {
        yield 'Arabic' => ['ar', false];
        yield 'German' => ['de', false];
        yield 'English' => ['en', false];
        yield 'Spanish' => ['es', false];
        yield 'French' => ['fr', false];
        yield 'Portuguese' => ['pt', false];
        yield 'Non-Existing' => ['non-existing', true];
    }
}
