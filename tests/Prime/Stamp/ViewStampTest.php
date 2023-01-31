<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\ViewStamp;
use Flasher\Tests\Prime\TestCase;

class ViewStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testViewStamp()
    {
        $stamp = new ViewStamp('template.html.twig');

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals('template.html.twig', $stamp->getView());
        $this->assertEquals(array('view' => 'template.html.twig'), $stamp->toArray());
    }
}
