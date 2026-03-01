<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\EventListener;

use Flasher\Laravel\EventListener\OctaneListener;
use PHPUnit\Framework\TestCase;

final class OctaneListenerTest extends TestCase
{
    public function testListenerIsInvokable(): void
    {
        $listener = new OctaneListener();

        // Verify the listener is invokable (has __invoke method)
        // This is crucial for Laravel's event dispatcher to call it correctly
        $this->assertTrue(is_callable($listener));
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
}
