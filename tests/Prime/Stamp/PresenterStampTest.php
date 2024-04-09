<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PresenterStamp;
use PHPUnit\Framework\TestCase;

final class PresenterStampTest extends TestCase
{
    // Test for the getPattern method of the PresenterStamp class
    public function testGetPattern(): void
    {
        $pattern = '/test-pattern/';
        $presenterStamp = new PresenterStamp($pattern);
        $this->assertSame($pattern, $presenterStamp->getPattern());
    }

    // Test for invalid pattern in PresenterStamp class
    public function testInvalidPatternThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $invalidPattern = '[invalid-pattern';
        $presenterStamp = new PresenterStamp($invalidPattern);
    }
}
