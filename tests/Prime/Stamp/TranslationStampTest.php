<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\TranslationStamp;
use PHPUnit\Framework\TestCase;

final class TranslationStampTest extends TestCase
{
    /**
     * Test if the getParameters method returns correct parameters.
     */
    public function testGetParameters(): void
    {
        $parameters = ['param1' => 'value1', 'param2' => 'value2'];

        // Create a TranslationStamp instance with parameters
        $translationStamp = new TranslationStamp($parameters);

        // Assert that the getParameters method should return the same parameters as those given to the constructor
        $this->assertSame($parameters, $translationStamp->getParameters());
    }

    /**
     * Test if the getParameters method returns an empty array when no parameters are provided.
     */
    public function testGetParametersEmpty(): void
    {
        // Create a TranslationStamp instance without providing parameters
        $translationStamp = new TranslationStamp();

        // Assert that the getParameters method should return an empty array
        $this->assertSame([], $translationStamp->getParameters());
    }

    /**
     * Test if the getLocale method returns the correct locale.
     */
    public function testGetLocale(): void
    {
        $locale = 'en_US';

        // Create a TranslationStamp instance with a locale
        $translationStamp = new TranslationStamp([], $locale);

        // Assert that the getLocale method should return the same locale as that given to the constructor
        $this->assertSame($locale, $translationStamp->getLocale());
    }

    /**
     * Test if the getLocale method returns null when no locale is provided.
     */
    public function testGetLocaleNull(): void
    {
        // Create a TranslationStamp instance without providing a locale
        $translationStamp = new TranslationStamp();

        // Assert that the getLocale method should return null
        $this->assertNull($translationStamp->getLocale());
    }
}
