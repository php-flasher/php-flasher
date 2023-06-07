<?php

namespace Flasher\Tests\Symfony;

use Flasher\Symfony\Translation\Translator;

class TranslatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testInitialState()
    {
        $translator = $this->getTranslator();

        $this->assertEquals('en', $translator->getLocale());
    }

    /**
     * @return Translator
     */
    private function getTranslator()
    {
        $messageFormatter = null;
        if (class_exists('Symfony\Component\Translation\Formatter\MessageFormatter')) {
            $messageFormatter = new \Symfony\Component\Translation\Formatter\MessageFormatter();
        } elseif (class_exists('Symfony\Component\Translation\MessageSelector')) {
            $messageFormatter = new \Symfony\Component\Translation\MessageSelector();
        }

        $symfonyTranslator = new \Symfony\Component\Translation\Translator('en', $messageFormatter);

        return new Translator($symfonyTranslator);
    }
}
