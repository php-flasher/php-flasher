<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Support\Traits;

use Flasher\Prime\Support\Traits\Macroable;
use PHPUnit\Framework\TestCase;

final class MacroableTest extends TestCase
{
    public function testMacroRegistrationAndExecution(): void
    {
        $macroableClass = new class() {
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
        $macroableClass = new class() {
            use Macroable;
        };

        $mixin = new class() {
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
        $macroableClass = new class() {
            use Macroable;
        };

        $this->expectException(\BadMethodCallException::class);
        $macroableClass::nonExistingMacro(); // @phpstan-ignore-line
    }

    public function testExceptionForNonCallableMacro(): void
    {
        $macroableClass = new class() {
            use Macroable;
        };

        $macroableClass::macro('nonCallable', new \stdClass());
        $this->expectException(\BadMethodCallException::class);
        $macroableClass::nonCallable(); // @phpstan-ignore-line
    }
}
