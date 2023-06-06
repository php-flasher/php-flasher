<?php

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Tests\Prime\TestCase;

class EchoTranslatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testEchoTranslator()
    {
        $translator = new EchoTranslator();

        $this->assertEquals('en', $translator->getLocale());
        $this->assertEquals('PHPFlasher', $translator->translate('PHPFlasher'));
    }
}
