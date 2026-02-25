<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Support\Traits;

use Flasher\Prime\Support\Traits\Macroable;
use PHPUnit\Framework\TestCase;

final class MacroableTest extends TestCase
{
    public function testMacroRegistrationAndExecution(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $macroableClass::macro('testMacro', static function () {
            return 'macro result';
        });

        $this->assertTrue($macroableClass::hasMacro('testMacro'));
        $this->assertSame('macro result', $macroableClass::testMacro()); // @phpstan-ignore-line
    }

    public function testMixin(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $mixin = new class {
            public function mixedInMethod(): callable
            {
                return static function () {
                    return 'mixed in';
                };
            }
        };

        $macroableClass::mixin($mixin);

        $this->assertTrue($macroableClass::hasMacro('mixedInMethod'));
        $this->assertSame('mixed in', $macroableClass::mixedInMethod()); // @phpstan-ignore-line
    }

    public function testExceptionForNonExistingMacro(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $this->expectException(\BadMethodCallException::class);
        $macroableClass::nonExistingMacro(); // @phpstan-ignore-line
    }

    public function testExceptionForNonCallableMacro(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $macroableClass::macro('nonCallable', new \stdClass());
        $this->expectException(\BadMethodCallException::class);
        $macroableClass::nonCallable(); // @phpstan-ignore-line
    }

    public function testInstanceCallMethod(): void
    {
        $macroableClass = new class {
            use Macroable;

            public string $value = 'instance value';
        };

        $macroableClass::macro('getValue', function () {
            return $this->value; // @phpstan-ignore-line
        });

        $instance = $macroableClass;
        $this->assertSame('instance value', $instance->getValue()); // @phpstan-ignore-line
    }

    public function testInstanceCallWithParameters(): void
    {
        $macroableClass = new class {
            use Macroable;

            public string $prefix = 'Hello, ';
        };

        $macroableClass::macro('greet', function (string $name) {
            return $this->prefix.$name; // @phpstan-ignore-line
        });

        $instance = $macroableClass;
        $this->assertSame('Hello, World', $instance->greet('World')); // @phpstan-ignore-line
    }

    public function testExceptionForNonExistingMacroOnInstance(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $instance = $macroableClass;
        $this->expectException(\BadMethodCallException::class);
        $instance->nonExistingMacro(); // @phpstan-ignore-line
    }

    public function testExceptionForNonCallableMacroOnInstance(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $macroableClass::macro('nonCallable', new \stdClass());
        $instance = $macroableClass;
        $this->expectException(\BadMethodCallException::class);
        $instance->nonCallable(); // @phpstan-ignore-line
    }

    public function testMixinWithReplaceTrue(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $macroableClass::macro('existingMethod', static function () {
            return 'original';
        });

        $mixin = new class {
            public function existingMethod(): callable
            {
                return static function () {
                    return 'replaced';
                };
            }
        };

        $macroableClass::mixin($mixin, true);

        $this->assertSame('replaced', $macroableClass::existingMethod()); // @phpstan-ignore-line
    }

    public function testMixinWithReplaceFalse(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $macroableClass::macro('existingMethod', static function () {
            return 'original';
        });

        $mixin = new class {
            public function existingMethod(): callable
            {
                return static function () {
                    return 'should not replace';
                };
            }

            public function newMethod(): callable
            {
                return static function () {
                    return 'new method';
                };
            }
        };

        $macroableClass::mixin($mixin, false);

        $this->assertSame('original', $macroableClass::existingMethod()); // @phpstan-ignore-line
        $this->assertSame('new method', $macroableClass::newMethod()); // @phpstan-ignore-line
    }

    public function testMixinThrowsExceptionForNonCallableReturn(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $mixin = new class {
            public function badMethod(): string
            {
                return 'not callable';
            }
        };

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expect the result of method');
        $macroableClass::mixin($mixin);
    }

    public function testMixinWithObjectMacro(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $mixin = new class {
            public function invokableMethod(): object
            {
                return new class {
                    public function __invoke(): string
                    {
                        return 'invokable result';
                    }
                };
            }
        };

        $macroableClass::mixin($mixin);

        $this->assertSame('invokable result', $macroableClass::invokableMethod()); // @phpstan-ignore-line
    }

    public function testStaticCallWithParameters(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $macroableClass::macro('add', static function (int $a, int $b) {
            return $a + $b;
        });

        $this->assertSame(5, $macroableClass::add(2, 3)); // @phpstan-ignore-line
    }

    public function testHasMacroReturnsFalse(): void
    {
        $macroableClass = new class {
            use Macroable;
        };

        $this->assertFalse($macroableClass::hasMacro('nonExistent'));
    }
}
