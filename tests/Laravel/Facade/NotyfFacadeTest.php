<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Facade;

use Flasher\Notyf\Laravel\Facade\Notyf;
use Flasher\Prime\Notification\Envelope;
use Flasher\Tests\Laravel\TestCase;

final class NotyfFacadeTest extends TestCase
{
    public function testFacadeAccessor(): void
    {
        $this->assertSame('flasher.notyf', $this->getFacadeAccessor(Notyf::class));
    }

    public function testSuccess(): void
    {
        $envelope = Notyf::success('Success message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
        $this->assertSame('Success message', $envelope->getMessage());
    }

    public function testError(): void
    {
        $envelope = Notyf::error('Error message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('error', $envelope->getType());
        $this->assertSame('Error message', $envelope->getMessage());
    }

    public function testWarning(): void
    {
        $envelope = Notyf::warning('Warning message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('warning', $envelope->getType());
        $this->assertSame('Warning message', $envelope->getMessage());
    }

    public function testInfo(): void
    {
        $envelope = Notyf::info('Info message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('info', $envelope->getType());
        $this->assertSame('Info message', $envelope->getMessage());
    }

    public function testFlash(): void
    {
        $envelope = Notyf::flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testDuration(): void
    {
        $envelope = Notyf::duration(5000)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testRipple(): void
    {
        $envelope = Notyf::ripple(true)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPosition(): void
    {
        $envelope = Notyf::position('x', 'right')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testDismissible(): void
    {
        $envelope = Notyf::dismissible(true)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testBackground(): void
    {
        $envelope = Notyf::background('#ff0000')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPriority(): void
    {
        $envelope = Notyf::priority(5)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(5, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $envelope = Notyf::hops(2)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $envelope = Notyf::keep()->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $envelope = Notyf::delay(1000)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(1000, $stamp->getDelay());
    }

    public function testHandler(): void
    {
        $envelope = Notyf::handler('notyf')->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PluginStamp');
        $this->assertNotNull($stamp);
        $this->assertSame('notyf', $stamp->getPlugin());
    }

    public function testWith(): void
    {
        $stamp = new \Flasher\Prime\Stamp\PriorityStamp(5);
        $envelope = Notyf::with([$stamp])->success('Test');

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($priorityStamp);
        $this->assertSame(5, $priorityStamp->getPriority());
    }

    public function testChainedMethods(): void
    {
        $envelope = Notyf::message('Test message')
            ->duration(5000)
            ->ripple(true)
            ->position('x', 'right')
            ->position('y', 'top')
            ->dismissible(true)
            ->flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('Test message', $envelope->getMessage());
    }

    private function getFacadeAccessor(string $facadeClass): string
    {
        $reflection = new \ReflectionClass($facadeClass);
        $method = $reflection->getMethod('getFacadeAccessor');
        $method->setAccessible(true);

        return $method->invoke(null);
    }
}
