<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Storage;

use Flasher\Laravel\Storage\FallbackSession;
use PHPUnit\Framework\TestCase;

final class FallbackSessionTest extends TestCase
{
    protected function tearDown(): void
    {
        FallbackSession::reset();
    }

    public function testGetReturnsDefaultWhenKeyNotSet(): void
    {
        $session = new FallbackSession();

        $this->assertNull($session->get('nonexistent'));
        $this->assertSame('default', $session->get('nonexistent', 'default'));
    }

    public function testSetAndGet(): void
    {
        $session = new FallbackSession();

        $session->set('key', 'value');

        $this->assertSame('value', $session->get('key'));
    }

    public function testSetOverwritesExistingValue(): void
    {
        $session = new FallbackSession();

        $session->set('key', 'first');
        $session->set('key', 'second');

        $this->assertSame('second', $session->get('key'));
    }

    public function testResetClearsAllData(): void
    {
        $session = new FallbackSession();

        $session->set('key1', 'value1');
        $session->set('key2', 'value2');

        FallbackSession::reset();

        $this->assertNull($session->get('key1'));
        $this->assertNull($session->get('key2'));
    }

    public function testStaticStorageIsSharedAcrossInstances(): void
    {
        $session1 = new FallbackSession();
        $session2 = new FallbackSession();

        $session1->set('shared_key', 'shared_value');

        // Value should be accessible from another instance
        $this->assertSame('shared_value', $session2->get('shared_key'));
    }

    public function testResetAffectsAllInstances(): void
    {
        $session1 = new FallbackSession();
        $session2 = new FallbackSession();

        $session1->set('key', 'value');

        FallbackSession::reset();

        // Both instances should see the reset
        $this->assertNull($session1->get('key'));
        $this->assertNull($session2->get('key'));
    }

    public function testCanStoreArrayValues(): void
    {
        $session = new FallbackSession();
        $envelopes = [
            ['message' => 'Test 1'],
            ['message' => 'Test 2'],
        ];

        $session->set('flasher::envelopes', $envelopes);

        $this->assertSame($envelopes, $session->get('flasher::envelopes'));
    }
}
