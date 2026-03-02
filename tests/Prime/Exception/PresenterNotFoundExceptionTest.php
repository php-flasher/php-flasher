<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Exception;

use Flasher\Prime\Exception\PresenterNotFoundException;
use PHPUnit\Framework\TestCase;

final class PresenterNotFoundExceptionTest extends TestCase
{
    public function testCreateWithAliasOnly(): void
    {
        $exception = PresenterNotFoundException::create('xml');

        $this->assertSame('Presenter "xml" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testCreateWithAvailablePresenters(): void
    {
        $exception = PresenterNotFoundException::create('xml', ['html', 'json', 'array']);

        $this->assertSame('Presenter "xml" not found, did you forget to register it? Available presenters: [html, json, array]', $exception->getMessage());
    }

    public function testCreateWithEmptyAvailablePresenters(): void
    {
        $exception = PresenterNotFoundException::create('xml', []);

        $this->assertSame('Presenter "xml" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testIsException(): void
    {
        $exception = PresenterNotFoundException::create('test');

        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
