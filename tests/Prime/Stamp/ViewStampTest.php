<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\ViewStamp;
use Flasher\Tests\Prime\TestCase;

final class ViewStampTest extends TestCase
{
    public function testViewStamp(): void
    {
        $stamp = new ViewStamp('template.html.twig');

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertEquals('template.html.twig', $stamp->getView());
        $this->assertEquals(['view' => 'template.html.twig'], $stamp->toArray());
    }
}
