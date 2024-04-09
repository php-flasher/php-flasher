<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Support\Traits;

use Flasher\Prime\Support\Traits\ForwardsCalls;
use PHPUnit\Framework\TestCase;

final class ForwardsCallsTest extends TestCase
{
    public function testSuccessfulMethodForwarding(): void
    {
        $testable = new class() {
            use ForwardsCalls;
        };

        $secondary = new class() {
            public function someMethod(): string
            {
                return 'method result';
            }
        };

        $reflection = new \ReflectionClass($testable::class);
        $method = $reflection->getMethod('forwardCallTo');

        $result = $method->invokeArgs($testable, [$secondary, 'someMethod', []]);
        $this->assertSame('method result', $result);
    }

    public function testForwardingAndReturningThis(): void
    {
        $testable = new class() {
            use ForwardsCalls;
        };

        $secondary = new class() {
            public function selfReturningMethod(): self
            {
                return $this;
            }
        };

        $reflection = new \ReflectionClass($testable::class);
        $method = $reflection->getMethod('forwardDecoratedCallTo');

        $result = $method->invokeArgs($testable, [$secondary, 'selfReturningMethod', []]);
        $this->assertNotSame($secondary, $result);
        $this->assertInstanceOf($testable::class, $result);
    }

    public function testUndefinedMethodCall(): void
    {
        $testable = new class() {
            use ForwardsCalls;
        };

        $secondary = new class() {
            // This class intentionally left blank to simulate an undefined method call.
        };

        // Use reflection to change visibility
        $reflection = new \ReflectionClass($testable::class);
        $method = $reflection->getMethod('forwardCallTo');

        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Call to undefined method class@anonymous::undefinedMethod()');
        $method->invokeArgs($testable, [$secondary, 'undefinedMethod', []]);
    }
}
