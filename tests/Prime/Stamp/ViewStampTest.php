<?php

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
        $this->assertEquals(['view' => 'template.html.twig'], $stamp->toArray());
    }
}
