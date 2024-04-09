<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Storage;

use Flasher\Symfony\Storage\FallbackSession;
use PHPUnit\Framework\TestCase;

/**
 * This class provides a complete test coverage for the FallbackSession class.
 * The FallbackSession class provides methods to get and set data in a fallback session storage.
 */
final class FallbackSessionTest extends TestCase
{
    private FallbackSession $session;

    protected function setUp(): void
    {
        $this->session = new FallbackSession();
    }

    public function testGetReturnsSetValue(): void
    {
        $this->session->set('test_name', 'test_value');
        $value = $this->session->get('test_name');
        $this->assertSame('test_value', $value);
    }

    public function testGetReturnsDefaultValueIfNameNotExists(): void
    {
        $value = $this->session->get('not_existing_name', 'default_value');
        $this->assertSame('default_value', $value);
    }

    public function testGetReturnsNullIfNameNotExistsAndNoDefaultValueProvided(): void
    {
        $value = $this->session->get('not_existing_name');
        $this->assertNull($value);
    }

    public function testSetStoresValueInSession(): void
    {
        $this->session->set('test_name', 'test_value');
        $value = $this->session->get('test_name', 'default_value');
        $this->assertSame('test_value', $value);
    }
}
