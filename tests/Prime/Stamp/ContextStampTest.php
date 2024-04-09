<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\ContextStamp;
use PHPUnit\Framework\TestCase;

final class ContextStampTest extends TestCase
{
    public function testGetContextReturnsTheCorrectArray(): void
    {
        $contextArray = ['key1' => 'value1', 'key2' => 'value2'];

        $contextStamp = new ContextStamp($contextArray);

        $this->assertSame(
            $contextArray,
            $contextStamp->getContext(),
            'The getContext method did not return the expected array.'
        );
    }

    public function testGetContextWithEmptyArray(): void
    {
        $contextArray = [];

        $contextStamp = new ContextStamp($contextArray);

        $this->assertSame(
            $contextArray,
            $contextStamp->getContext(),
            'The getContext method did not return an empty array with empty context.'
        );
    }

    public function testToArrayReturnsContextInArray(): void
    {
        $contextArray = ['key1' => 'value1', 'key2' => 'value2'];

        $contextStamp = new ContextStamp($contextArray);

        $this->assertSame(
            ['context' => $contextArray],
            $contextStamp->toArray(),
            'The toArray method did not return the expected array.'
        );
    }

    public function testToArrayWithEmptyArray(): void
    {
        $contextArray = [];

        $contextStamp = new ContextStamp($contextArray);

        $this->assertSame(
            ['context' => $contextArray],
            $contextStamp->toArray(),
            'The toArray method did not return an array with empty context as expected.'
        );
    }
}
