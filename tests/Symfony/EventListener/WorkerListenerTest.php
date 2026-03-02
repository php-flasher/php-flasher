<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\EventListener;

use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandlerInterface;
use Flasher\Symfony\EventListener\WorkerListener;
use Flasher\Symfony\Storage\FallbackSession;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Service\ResetInterface;

final class WorkerListenerTest extends TestCase
{
    /** @var MockObject&ContentSecurityPolicyHandlerInterface */
    private MockObject $cspHandler;

    protected function setUp(): void
    {
        $this->cspHandler = $this->createMock(ContentSecurityPolicyHandlerInterface::class);
    }

    protected function tearDown(): void
    {
        FallbackSession::reset();
    }

    public function testListenerImplementsResetInterface(): void
    {
        $listener = new WorkerListener($this->cspHandler);

        $this->assertInstanceOf(ResetInterface::class, $listener);
    }

    public function testResetClearsFallbackSessionStorage(): void
    {
        // Set up some data in FallbackSession
        $fallbackSession = new FallbackSession();
        $fallbackSession->set('flasher::envelopes', ['test_envelope']);

        // Verify data is stored
        $this->assertSame(['test_envelope'], $fallbackSession->get('flasher::envelopes'));

        // Mock CSP handler to expect reset call
        $this->cspHandler->expects($this->once())->method('reset');

        // Reset via WorkerListener
        $listener = new WorkerListener($this->cspHandler);
        $listener->reset();

        // Verify FallbackSession was reset
        $this->assertNull($fallbackSession->get('flasher::envelopes'));
    }

    public function testResetIsIdempotent(): void
    {
        $this->cspHandler->expects($this->exactly(3))->method('reset');

        $listener = new WorkerListener($this->cspHandler);

        // Should not throw when called multiple times
        $listener->reset();
        $listener->reset();
        $listener->reset();

        $this->assertTrue(true);
    }

    public function testResetCallsCspHandlerReset(): void
    {
        $this->cspHandler->expects($this->once())->method('reset');

        $listener = new WorkerListener($this->cspHandler);
        $listener->reset();
    }
}
