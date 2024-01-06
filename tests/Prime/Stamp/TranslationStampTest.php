<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Tests\Prime\TestCase;

final class TranslationStampTest extends TestCase
{
    public function testTranslationStamp(): void
    {
        $stamp = new TranslationStamp(['foo' => 'bar'], 'ar');

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertEquals(['foo' => 'bar'], $stamp->getParameters());
        $this->assertEquals('ar', $stamp->getLocale());
    }
}
