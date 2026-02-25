<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Facade;

use Flasher\Prime\Notification\Envelope;
use Flasher\SweetAlert\Laravel\Facade\SweetAlert;
use Flasher\Tests\Laravel\TestCase;

final class SweetAlertFacadeTest extends TestCase
{
    public function testFacadeAccessor(): void
    {
        $this->assertSame('flasher.sweetalert', $this->getFacadeAccessor(SweetAlert::class));
    }

    public function testSuccess(): void
    {
        $envelope = SweetAlert::success('Success message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
        $this->assertSame('Success message', $envelope->getMessage());
    }

    public function testError(): void
    {
        $envelope = SweetAlert::error('Error message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('error', $envelope->getType());
        $this->assertSame('Error message', $envelope->getMessage());
    }

    public function testWarning(): void
    {
        $envelope = SweetAlert::warning('Warning message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('warning', $envelope->getType());
        $this->assertSame('Warning message', $envelope->getMessage());
    }

    public function testInfo(): void
    {
        $envelope = SweetAlert::info('Info message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('info', $envelope->getType());
        $this->assertSame('Info message', $envelope->getMessage());
    }

    public function testQuestion(): void
    {
        $envelope = SweetAlert::question('Question message')->flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('question', $envelope->getType());
        $this->assertSame('Question message', $envelope->getMessage());
    }

    public function testFlash(): void
    {
        $envelope = SweetAlert::flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testToast(): void
    {
        $envelope = SweetAlert::toast()->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPosition(): void
    {
        $envelope = SweetAlert::position('center')->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testTimer(): void
    {
        $envelope = SweetAlert::timer(3000)->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testShowConfirmButton(): void
    {
        $envelope = SweetAlert::showConfirmButton()->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testShowCancelButton(): void
    {
        $envelope = SweetAlert::showCancelButton()->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testPriority(): void
    {
        $envelope = SweetAlert::priority(5)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(5, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $envelope = SweetAlert::hops(2)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $envelope = SweetAlert::keep()->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $envelope = SweetAlert::delay(1000)->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');
        $this->assertNotNull($stamp);
        $this->assertSame(1000, $stamp->getDelay());
    }

    public function testHandler(): void
    {
        $envelope = SweetAlert::handler('sweetalert')->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PluginStamp');
        $this->assertNotNull($stamp);
        $this->assertSame('sweetalert', $stamp->getPlugin());
    }

    public function testWith(): void
    {
        $stamp = new \Flasher\Prime\Stamp\PriorityStamp(5);
        $envelope = SweetAlert::with([$stamp])->success('Test');

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($priorityStamp);
        $this->assertSame(5, $priorityStamp->getPriority());
    }

    public function testChainedMethods(): void
    {
        $envelope = SweetAlert::message('Test message')
            ->title('Test Title')
            ->icon('success')
            ->toast()
            ->position('top-end')
            ->timer(3000)
            ->timerProgressBar()
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
