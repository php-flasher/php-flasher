<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\Language;
use Flasher\Tests\Prime\TestCase;

class LanguageTest extends TestCase
{
    /**
     * @return void
     */
    public function testLanguageDirection()
    {
        $this->assertEquals(Language::RTL, Language::direction('ar'));
        $this->assertEquals(Language::LTR, Language::direction('fr'));
        $this->assertEquals(Language::LTR, Language::direction('unknown'));
    }

    /**
     * @return void
     */
    public function testIsRTL()
    {
        $this->assertTrue(Language::isRTL('ar_AE'));
        $this->assertFalse(Language::isRTL('en_US'));
    }

    /**
     * @return void
     */
    public function testIsLTR()
    {
        $this->assertTrue(Language::isLTR('en_US'));
        $this->assertFalse(Language::isLTR('ar_AE'));
    }
}
