<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Tests\Prime\TestCase;

class TranslationStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testTranslationStamp()
    {
        $stamp = new TranslationStamp(['foo' => 'bar'], 'ar');

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals(['foo' => 'bar'], $stamp->getParameters());
        $this->assertEquals('ar', $stamp->getLocale());
    }

    /**
     * @return void
     */
    public function testParametersOrder()
    {
        $parameters = TranslationStamp::parametersOrder('ar');

        $this->assertEquals(['locale' => 'ar', 'parameters' => []], $parameters);
    }
}
