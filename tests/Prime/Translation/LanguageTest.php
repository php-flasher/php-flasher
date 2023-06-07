<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\Language;
use Flasher\Tests\Prime\TestCase;

final class LanguageTest extends TestCase
{
    public function testLanguageDirection(): void
    {
        $this->assertEquals(Language::RTL, Language::direction('ar'));
        $this->assertEquals(Language::LTR, Language::direction('fr'));
        $this->assertEquals(Language::LTR, Language::direction('unknown'));
    }

    public function testIsRTL(): void
    {
        $this->assertTrue(Language::isRTL('ar_AE'));
        $this->assertFalse(Language::isRTL('en_US'));
    }

    public function testIsLTR(): void
    {
        $this->assertTrue(Language::isLTR('en_US'));
        $this->assertFalse(Language::isLTR('ar_AE'));
    }
}
