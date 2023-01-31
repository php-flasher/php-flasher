<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
        $stamp = new TranslationStamp(array('foo' => 'bar'), 'ar');

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals(array('foo' => 'bar'), $stamp->getParameters());
        $this->assertEquals('ar', $stamp->getLocale());
    }

    /**
     * @return void
     */
    public function testParametersOrder()
    {
        $parameters = TranslationStamp::parametersOrder('ar');

        $this->assertEquals(array('locale' => 'ar', 'parameters' => array()), $parameters);
    }
}
