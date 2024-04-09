<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\UnlessStamp;
use PHPUnit\Framework\TestCase;

final class UnlessStampTest extends TestCase
{
    // Test case for getCondition() method
    public function testGetCondition(): void
    {
        // Create a testable instance of UnlessStamp class
        $unlessStamp = new UnlessStamp(true);

        // Assert that getCondition correctly returns the value passed in the constructor
        $this->assertTrue($unlessStamp->getCondition());

        // Create another testable instance of UnlessStamp class
        $unlessStamp = new UnlessStamp(false);

        // Again assert that getCondition correctly returns the value passed in the constructor
        $this->assertFalse($unlessStamp->getCondition());
    }
}
