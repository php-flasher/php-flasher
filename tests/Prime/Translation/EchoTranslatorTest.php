<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Tests\Prime\TestCase;

final class EchoTranslatorTest extends TestCase
{
    public function testEchoTranslator(): void
    {
        $translator = new EchoTranslator();

        $this->assertEquals('en', $translator->getLocale());
        $this->assertEquals('PHPFlasher', $translator->translate('PHPFlasher'));
    }
}
