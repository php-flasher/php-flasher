<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Support\Traits;

use Flasher\Prime\Support\Traits\ForwardsCalls;
use PHPUnit\Framework\TestCase;

final class ForwardsCallsTest extends TestCase
{
    public function testSuccessfulMethodForwarding(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function someMethod(): string
            {
                return 'method result';
            }
        };

        $result = $testable->callForward($secondary, 'someMethod', []);
        $this->assertSame('method result', $result);
    }

    public function testForwardingWithParameters(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function methodWithParams(string $name, int $age): string
            {
                return "{$name} is {$age} years old";
            }
        };

        $result = $testable->callForward($secondary, 'methodWithParams', ['John', 30]);
        $this->assertSame('John is 30 years old', $result);
    }

    public function testForwardingAndReturningThis(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callDecoratedForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardDecoratedCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function selfReturningMethod(): self
            {
                return $this;
            }
        };

        $result = $testable->callDecoratedForward($secondary, 'selfReturningMethod', []);
        $this->assertNotSame($secondary, $result);
        $this->assertInstanceOf($testable::class, $result);
    }

    public function testForwardDecoratedReturnsOtherValue(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callDecoratedForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardDecoratedCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function returnsString(): string
            {
                return 'not self';
            }
        };

        $result = $testable->callDecoratedForward($secondary, 'returnsString', []);
        $this->assertSame('not self', $result);
    }

    public function testThrowBadMethodCallException(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public static function callThrowBadMethod(string $method): never
            {
                static::throwBadMethodCallException($method);
            }
        };

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessageMatches('/Call to undefined method .+::nonExistentMethod\(\)/');

        $testable::callThrowBadMethod('nonExistentMethod');
    }

    public function testUndefinedMethodCallThrowsError(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            // Intentionally empty
        };

        // For anonymous classes, the class name comparison in ForwardsCalls fails,
        // so the original Error is rethrown instead of being converted to BadMethodCallException
        $this->expectException(\Error::class);
        $this->expectExceptionMessageMatches('/Call to undefined method .+::undefinedMethod\(\)/');

        $testable->callForward($secondary, 'undefinedMethod', []);
    }

    public function testForwardCallRethrowsNonMatchingError(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function methodThatThrows(): void
            {
                throw new \Error('Some other error message');
            }
        };

        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Some other error message');

        $testable->callForward($secondary, 'methodThatThrows', []);
    }

    public function testForwardCallRethrowsBadMethodCallException(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function methodThatThrowsBadMethod(): void
            {
                throw new \BadMethodCallException('Custom bad method message');
            }
        };

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Custom bad method message');

        $testable->callForward($secondary, 'methodThatThrowsBadMethod', []);
    }

    public function testForwardCallWithNullReturn(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function returnsNull(): ?string
            {
                return null;
            }
        };

        $result = $testable->callForward($secondary, 'returnsNull', []);
        $this->assertNull($result);
    }

    public function testForwardCallWithArrayReturn(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function returnsArray(): array
            {
                return ['a', 'b', 'c'];
            }
        };

        $result = $testable->callForward($secondary, 'returnsArray', []);
        $this->assertSame(['a', 'b', 'c'], $result);
    }

    public function testForwardDecoratedCallWithNonSelfReturn(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callDecoratedForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardDecoratedCallTo($object, $method, $parameters);
            }
        };

        $otherObject = new \stdClass();
        $secondary = new class($otherObject) {
            public function __construct(private object $other)
            {
            }

            public function returnsOther(): object
            {
                return $this->other;
            }
        };

        $result = $testable->callDecoratedForward($secondary, 'returnsOther', []);
        $this->assertSame($otherObject, $result);
    }

    public function testForwardCallPreservesMethodArguments(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function sumNumbers(int ...$numbers): int
            {
                return array_sum($numbers);
            }
        };

        $result = $testable->callForward($secondary, 'sumNumbers', [1, 2, 3, 4, 5]);
        $this->assertSame(15, $result);
    }

    public function testForwardCallWithMixedParameters(): void
    {
        $testable = new class {
            use ForwardsCalls;

            public function callForward(object $object, string $method, array $parameters): mixed
            {
                return $this->forwardCallTo($object, $method, $parameters);
            }
        };

        $secondary = new class {
            public function mixedParams(string $str, int $num, array $arr, bool $flag): array
            {
                return compact('str', 'num', 'arr', 'flag');
            }
        };

        $result = $testable->callForward($secondary, 'mixedParams', ['test', 42, ['a', 'b'], true]);
        $this->assertSame([
            'str' => 'test',
            'num' => 42,
            'arr' => ['a', 'b'],
            'flag' => true,
        ], $result);
    }
}
