<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Exception;

use Flasher\Prime\Exception\FactoryNotFoundException;
use PHPUnit\Framework\TestCase;

final class FactoryNotFoundExceptionTest extends TestCase
{
    public function testCreateWithAliasOnly(): void
    {
        $exception = FactoryNotFoundException::create('custom_factory');

        $this->assertSame('Factory "custom_factory" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testCreateWithAvailableFactories(): void
    {
        $exception = FactoryNotFoundException::create('custom_factory', ['flasher', 'toastr', 'noty']);

        $this->assertSame('Factory "custom_factory" not found, did you forget to register it? Available factories: [flasher, toastr, noty]', $exception->getMessage());
    }

    public function testCreateWithEmptyAvailableFactories(): void
    {
        $exception = FactoryNotFoundException::create('custom_factory', []);

        $this->assertSame('Factory "custom_factory" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testIsException(): void
    {
        $exception = FactoryNotFoundException::create('test');

        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testStaticCreateReturnsInstance(): void
    {
        $exception = FactoryNotFoundException::create('alias');

        $this->assertInstanceOf(FactoryNotFoundException::class, $exception);
    }
}
