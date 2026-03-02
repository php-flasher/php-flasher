<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Type;
use PHPUnit\Framework\TestCase;

final class TypeTest extends TestCase
{
    public function testConstants(): void
    {
        $this->assertSame('success', Type::SUCCESS);
        $this->assertSame('error', Type::ERROR);
        $this->assertSame('info', Type::INFO);
        $this->assertSame('warning', Type::WARNING);
    }

    public function testAll(): void
    {
        $expected = ['success', 'error', 'info', 'warning'];
        $this->assertSame($expected, Type::all());
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('validTypesProvider')]
    public function testIsValidWithValidTypes(string $type): void
    {
        $this->assertTrue(Type::isValid($type));
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function validTypesProvider(): iterable
    {
        yield 'success' => ['success'];
        yield 'error' => ['error'];
        yield 'info' => ['info'];
        yield 'warning' => ['warning'];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidTypesProvider')]
    public function testIsValidWithInvalidTypes(string $type): void
    {
        $this->assertFalse(Type::isValid($type));
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function invalidTypesProvider(): iterable
    {
        yield 'invalid' => ['invalid'];
        yield 'empty' => [''];
        yield 'uppercase SUCCESS' => ['SUCCESS'];
        yield 'notice' => ['notice'];
    }
}
