<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Flasher\Symfony\Translation\Translator;

final class TranslatorTest extends TestCase
{
    public function testInitialState(): void
    {
        $translator = $this->getTranslator();

        $this->assertEquals('en', $translator->getLocale());
    }

    private function getTranslator(): Translator
    {
        $messageFormatter = null;
        if (class_exists(\Symfony\Component\Translation\Formatter\MessageFormatter::class)) {
            $messageFormatter = new \Symfony\Component\Translation\Formatter\MessageFormatter();
        } elseif (class_exists('Symfony\Component\Translation\MessageSelector')) {
            $messageFormatter = new \Symfony\Component\Translation\MessageSelector();
        }

        $symfonyTranslator = new \Symfony\Component\Translation\Translator('en', $messageFormatter);

        return new Translator($symfonyTranslator);
    }
}
