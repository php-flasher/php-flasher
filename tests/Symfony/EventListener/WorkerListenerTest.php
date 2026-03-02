<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\EventListener;

use Flasher\Symfony\EventListener\WorkerListener;
use Flasher\Symfony\Storage\FallbackSession;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Service\ResetInterface;

final class WorkerListenerTest extends TestCase
{
    protected function tearDown(): void
    {
        FallbackSession::reset();
    }

    public function testListenerImplementsResetInterface(): void
    {
        $listener = new WorkerListener();

        $this->assertInstanceOf(ResetInterface::class, $listener);
    }

    public function testResetClearsFallbackSessionStorage(): void
    {
        // Set up some data in FallbackSession
        $fallbackSession = new FallbackSession();
        $fallbackSession->set('flasher::envelopes', ['test_envelope']);

        // Verify data is stored
        $this->assertSame(['test_envelope'], $fallbackSession->get('flasher::envelopes'));

        // Reset via WorkerListener
        $listener = new WorkerListener();
        $listener->reset();

        // Verify FallbackSession was reset
        $this->assertNull($fallbackSession->get('flasher::envelopes'));
    }

    public function testResetIsIdempotent(): void
    {
        $listener = new WorkerListener();

        // Should not throw when called multiple times
        $listener->reset();
        $listener->reset();
        $listener->reset();

        $this->assertTrue(true);
    }
}
