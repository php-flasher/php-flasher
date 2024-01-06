<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Flasher\Symfony\Translation\Translator;
use Symfony\Component\Translation\Formatter\MessageFormatter;

final class TranslatorTest extends TestCase
{
    public function testInitialState(): void
    {
        $translator = $this->getTranslator();

        $this->assertEquals('en', $translator->getLocale());
    }

    private function getTranslator(): Translator
    {
        $symfonyTranslator = new \Symfony\Component\Translation\Translator('en', new MessageFormatter());

        return new Translator($symfonyTranslator);
    }
}
