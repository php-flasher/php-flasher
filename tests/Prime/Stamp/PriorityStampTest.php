<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class PriorityStampTest extends TestCase
{
    /**
     * Test case for getPriority method of PriorityStamp class.
     */
    public function testGetPriority(): void
    {
        // Define test priority
        $priority = 10;

        // Instantiate PriorityStamp
        $stamp = new PriorityStamp($priority);

        // Check if the result of getPriority is as expected
        $this->assertSame($priority, $stamp->getPriority());
    }

    /**
     * Test case for compare method of PriorityStamp class.
     */
    public function testCompare(): void
    {
        // Define test priorities
        $priority1 = 10;
        $priority2 = 20;

        // Instantiate PriorityStamps
        $stamp1 = new PriorityStamp($priority1);
        $stamp2 = new PriorityStamp($priority2);

        // Check if the result of compare is as expected
        $this->assertSame($priority1 - $priority2, $stamp1->compare($stamp2));
        $this->assertSame($priority2 - $priority1, $stamp2->compare($stamp1));
    }

    /**
     * Test case for toArray method of PriorityStamp class.
     */
    public function testToArray(): void
    {
        // Define test priority
        $priority = 10;

        // Instantiate PriorityStamp
        $stamp = new PriorityStamp($priority);

        // Check if the result of toArray is as expected
        $this->assertSame(['priority' => $priority], $stamp->toArray());
    }
}
