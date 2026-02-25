<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Facade;

use Flasher\Prime\Notification\Envelope;
use Flasher\Tests\Laravel\TestCase;
use Flasher\Toastr\Laravel\Facade\Toastr;

final class ToastrFacadeTest extends TestCase
{
    public function testFacadeAccessor(): void
    {
        $this->assertSame('flasher.toastr', $this->getFacadeAccessor(Toastr::class));
    }

    public function testSuccess(): void
    {
        $envelope = Toastr::success('Success message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
        $this->assertSame('Success message', $envelope->getMessage());
    }

    public function testError(): void
    {
        $envelope = Toastr::error('Error message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('error', $envelope->getType());
        $this->assertSame('Error message', $envelope->getMessage());
    }

    public function testWarning(): void
    {
        $envelope = Toastr::warning('Warning message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('warning', $envelope->getType());
        $this->assertSame('Warning message', $envelope->getMessage());
    }

    public function testInfo(): void
    {
        $envelope = Toastr::info('Info message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('info', $envelope->getType());
        $this->assertSame('Info message', $envelope->getMessage());
    }

    public function testFlash(): void
    {
        $envelope = Toastr::flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testCloseButton(): void
    {
        $envelope = Toastr::closeButton()->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testProgressBar(): void
    {
        $envelope = Toastr::progressBar()->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPositionClass(): void
    {
        $envelope = Toastr::positionClass('toast-top-right')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testTimeOut(): void
    {
        $envelope = Toastr::timeOut(5000)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPriority(): void
    {
        $envelope = Toastr::priority(5)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(5, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $envelope = Toastr::hops(2)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $envelope = Toastr::keep()->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $envelope = Toastr::delay(1000)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(1000, $stamp->getDelay());
    }

    public function testHandler(): void
    {
        $envelope = Toastr::handler('toastr')->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PluginStamp');
        $this->assertNotNull($stamp);
        $this->assertSame('toastr', $stamp->getPlugin());
    }

    public function testWith(): void
    {
        $stamp = new \Flasher\Prime\Stamp\PriorityStamp(5);
        $envelope = Toastr::with([$stamp])->success('Test');

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($priorityStamp);
        $this->assertSame(5, $priorityStamp->getPriority());
    }

    public function testPersistent(): void
    {
        $envelope = Toastr::persistent()->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testChainedMethods(): void
    {
        $envelope = Toastr::message('Test message')
            ->title('Test Title')
            ->closeButton()
            ->progressBar()
            ->positionClass('toast-top-right')
            ->timeOut(5000)
            ->flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('Test message', $envelope->getMessage());
        $this->assertSame('Test Title', $envelope->getTitle());
    }

    private function getFacadeAccessor(string $facadeClass): string
    {
        $reflection = new \ReflectionClass($facadeClass);
        $method = $reflection->getMethod('getFacadeAccessor');
        $method->setAccessible(true);

        return $method->invoke(null);
    }
}
