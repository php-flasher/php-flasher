<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Storage;

use Flasher\Laravel\Storage\FallbackSession;
use Flasher\Laravel\Storage\FallbackSessionInterface;
use PHPUnit\Framework\TestCase;

final class FallbackSessionTest extends TestCase
{
    private FallbackSession $session;

    protected function setUp(): void
    {
        parent::setUp();

        FallbackSession::reset();
        $this->session = new FallbackSession();
    }

    protected function tearDown(): void
    {
        FallbackSession::reset();
        parent::tearDown();
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(FallbackSessionInterface::class, $this->session);
    }

    public function testGetReturnsDefaultWhenKeyNotFound(): void
    {
        $this->assertNull($this->session->get('nonexistent'));
        $this->assertSame('default', $this->session->get('nonexistent', 'default'));
        $this->assertSame([], $this->session->get('nonexistent', []));
    }

    public function testSetAndGet(): void
    {
        $this->session->set('key', 'value');

        $this->assertSame('value', $this->session->get('key'));
    }

    public function testSetOverwritesExistingValue(): void
    {
        $this->session->set('key', 'value1');
        $this->session->set('key', 'value2');

        $this->assertSame('value2', $this->session->get('key'));
    }

    public function testStoresComplexData(): void
    {
        $data = [
            'nested' => [
                'array' => ['with', 'values'],
            ],
            'number' => 42,
            'null' => null,
        ];

        $this->session->set('complex', $data);

        $this->assertSame($data, $this->session->get('complex'));
    }

    public function testStaticStoragePersistsAcrossInstances(): void
    {
        $session1 = new FallbackSession();
        $session1->set('shared', 'data');

        $session2 = new FallbackSession();

        $this->assertSame('data', $session2->get('shared'));
    }

    public function testResetClearsAllData(): void
    {
        $this->session->set('key1', 'value1');
        $this->session->set('key2', 'value2');

        FallbackSession::reset();

        $this->assertNull($this->session->get('key1'));
        $this->assertNull($this->session->get('key2'));
    }

    public function testHandlesNullValue(): void
    {
        $this->session->set('null_key', null);

        $this->assertNull($this->session->get('null_key'));
        $this->assertNull($this->session->get('null_key', 'default'));
    }

    public function testHandlesEmptyString(): void
    {
        $this->session->set('empty', '');

        $this->assertSame('', $this->session->get('empty'));
        $this->assertSame('', $this->session->get('empty', 'default'));
    }

    public function testHandlesFalseValue(): void
    {
        $this->session->set('false', false);

        $this->assertFalse($this->session->get('false'));
        $this->assertFalse($this->session->get('false', 'default'));
    }

    public function testHandlesZeroValue(): void
    {
        $this->session->set('zero', 0);

        $this->assertSame(0, $this->session->get('zero'));
        $this->assertSame(0, $this->session->get('zero', 'default'));
    }

    public function testKeyExistsWithNullValue(): void
    {
        $this->session->set('exists_null', null);

        $this->assertNull($this->session->get('exists_null'));
        $this->assertNull($this->session->get('exists_null', 'should_not_return'));
    }
}
