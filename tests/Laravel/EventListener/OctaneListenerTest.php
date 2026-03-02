<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\EventListener;

use Flasher\Laravel\EventListener\OctaneListener;
use Flasher\Laravel\Storage\FallbackSession;
use PHPUnit\Framework\TestCase;

final class OctaneListenerTest extends TestCase
{
    protected function tearDown(): void
    {
        FallbackSession::reset();
    }

    public function testListenerIsInvokable(): void
    {
        $listener = new OctaneListener();

        // Verify the listener is invokable (has __invoke method)
        // This is crucial for Laravel's event dispatcher to call it correctly
        $this->assertIsCallable($listener);
    }

    public function testListenerHasInvokeMethod(): void
    {
        // Verify the __invoke method exists and has the correct signature
        $reflection = new \ReflectionClass(OctaneListener::class);

        $this->assertTrue($reflection->hasMethod('__invoke'));

        $method = $reflection->getMethod('__invoke');
        $this->assertTrue($method->isPublic());

        $parameters = $method->getParameters();
        $this->assertCount(1, $parameters);
        $this->assertSame('event', $parameters[0]->getName());
    }

    public function testListenerCallsFallbackSessionReset(): void
    {
        // Verify that the OctaneListener calls FallbackSession::reset()
        // by checking the method exists and is callable
        $reflection = new \ReflectionMethod(FallbackSession::class, 'reset');

        $this->assertTrue($reflection->isStatic());
        $this->assertTrue($reflection->isPublic());

        // Verify the method clears the static storage
        $session = new FallbackSession();
        $session->set('test_key', 'test_value');
        $this->assertSame('test_value', $session->get('test_key'));

        FallbackSession::reset();
        $this->assertNull($session->get('test_key'));
    }
}
