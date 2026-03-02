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

    public function testIsValidWithValidTypes(): void
    {
        $this->assertTrue(Type::isValid('success'));
        $this->assertTrue(Type::isValid('error'));
        $this->assertTrue(Type::isValid('info'));
        $this->assertTrue(Type::isValid('warning'));
    }

    public function testIsValidWithInvalidTypes(): void
    {
        $this->assertFalse(Type::isValid('invalid'));
        $this->assertFalse(Type::isValid(''));
        $this->assertFalse(Type::isValid('SUCCESS'));
        $this->assertFalse(Type::isValid('notice'));
    }
}
