<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation;

use Flasher\Prime\Translation\EchoTranslator;
use PHPUnit\Framework\TestCase;

final class EchoTranslatorTest extends TestCase
{
    private EchoTranslator $translator;

    protected function setUp(): void
    {
        $this->translator = new EchoTranslator();
    }

    /**
     * This method is for testing if the Translate method in EchoTranslator class returns the same
     * id it received as input without any transformations.
     */
    public function testTranslate(): void
    {
        $id = 'TestID';
        $parameters = [];
        $locale = null;

        $result = $this->translator->translate($id, $parameters, $locale);

        $this->assertSame($id, $result, 'The Translate method should return the same id it received as input');
    }

    /**
     * This method is for testing if the getLocale method in EchoTranslator class always returns 'en'.
     */
    public function testGetLocale(): void
    {
        $locale = $this->translator->getLocale();

        $this->assertSame('en', $locale, "The getLocale method should return 'en'");
    }
}
