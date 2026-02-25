<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Facade;

use Flasher\Noty\Laravel\Facade\Noty;
use Flasher\Prime\Notification\Envelope;
use Flasher\Tests\Laravel\TestCase;

final class NotyFacadeTest extends TestCase
{
    public function testFacadeAccessor(): void
    {
        $this->assertSame('flasher.noty', $this->getFacadeAccessor(Noty::class));
    }

    public function testSuccess(): void
    {
        $envelope = Noty::success('Success message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
        $this->assertSame('Success message', $envelope->getMessage());
    }

    public function testError(): void
    {
        $envelope = Noty::error('Error message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('error', $envelope->getType());
        $this->assertSame('Error message', $envelope->getMessage());
    }

    public function testWarning(): void
    {
        $envelope = Noty::warning('Warning message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('warning', $envelope->getType());
        $this->assertSame('Warning message', $envelope->getMessage());
    }

    public function testInfo(): void
    {
        $envelope = Noty::info('Info message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('info', $envelope->getType());
        $this->assertSame('Info message', $envelope->getMessage());
    }

    public function testFlash(): void
    {
        $envelope = Noty::flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPriority(): void
    {
        $envelope = Noty::priority(5)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(5, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $envelope = Noty::hops(2)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $envelope = Noty::keep()->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $envelope = Noty::delay(1000)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(1000, $stamp->getDelay());
    }

    public function testHandler(): void
    {
        $envelope = Noty::handler('noty')->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PluginStamp');
        $this->assertNotNull($stamp);
        $this->assertSame('noty', $stamp->getPlugin());
    }

    public function testWith(): void
    {
        $stamp = new \Flasher\Prime\Stamp\PriorityStamp(5);
        $envelope = Noty::with([$stamp])->success('Test');

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($priorityStamp);
        $this->assertSame(5, $priorityStamp->getPriority());
    }

    public function testLayout(): void
    {
        $envelope = Noty::layout('topCenter')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testTheme(): void
    {
        $envelope = Noty::theme('bootstrap')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testTimeout(): void
    {
        $envelope = Noty::timeout(5000)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testTimeoutFalse(): void
    {
        $envelope = Noty::timeout(false)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testProgressBar(): void
    {
        $envelope = Noty::progressBar(true)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testCloseWith(): void
    {
        $envelope = Noty::closeWith(['click', 'button'])->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testAnimation(): void
    {
        $envelope = Noty::animation('open', 'fadeIn')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testSounds(): void
    {
        $envelope = Noty::sounds('source', '/sounds/notification.mp3')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testDocTitle(): void
    {
        $envelope = Noty::docTitle('onTitle', 'New Notification')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testModal(): void
    {
        $envelope = Noty::modal(true)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testId(): void
    {
        $envelope = Noty::id('my-notification')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testForce(): void
    {
        $envelope = Noty::force(true)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testQueue(): void
    {
        $envelope = Noty::queue('global')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testKiller(): void
    {
        $envelope = Noty::killer('my-killer')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testContainer(): void
    {
        $envelope = Noty::container('flasher-container')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testButtons(): void
    {
        $envelope = Noty::buttons([
            ['text' => 'Ok', 'onClick' => 'function() {}'],
        ])->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testVisibilityControl(): void
    {
        $envelope = Noty::visibilityControl(true)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testChainedMethods(): void
    {
        $envelope = Noty::message('Test message')
            ->layout('topCenter')
            ->theme('bootstrap')
            ->timeout(5000)
            ->progressBar(true)
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
