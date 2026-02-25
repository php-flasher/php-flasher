<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Facade;

use Flasher\Laravel\Facade\Flasher;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Tests\Laravel\TestCase;

final class FlasherFacadeTest extends TestCase
{
    public function testFacadeAccessor(): void
    {
        $this->assertSame('flasher', $this->getFacadeAccessor(Flasher::class));
    }

    public function testSuccess(): void
    {
        $envelope = Flasher::success('Success message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
        $this->assertSame('Success message', $envelope->getMessage());
    }

    public function testError(): void
    {
        $envelope = Flasher::error('Error message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('error', $envelope->getType());
        $this->assertSame('Error message', $envelope->getMessage());
    }

    public function testWarning(): void
    {
        $envelope = Flasher::warning('Warning message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('warning', $envelope->getType());
        $this->assertSame('Warning message', $envelope->getMessage());
    }

    public function testInfo(): void
    {
        $envelope = Flasher::info('Info message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('info', $envelope->getType());
        $this->assertSame('Info message', $envelope->getMessage());
    }

    public function testFlash(): void
    {
        $envelope = Flasher::flash('success', 'Flash message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
        $this->assertSame('Flash message', $envelope->getMessage());
    }

    public function testFlashWithNullType(): void
    {
        $envelope = Flasher::flash();

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testCreated(): void
    {
        $envelope = Flasher::created('User');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testUpdated(): void
    {
        $envelope = Flasher::updated('User');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testDeleted(): void
    {
        $envelope = Flasher::deleted('User');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testSaved(): void
    {
        $envelope = Flasher::saved('User');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testOperation(): void
    {
        $envelope = Flasher::operation('created', 'Resource');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testPush(): void
    {
        $envelope = Flasher::push();

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testTitle(): void
    {
        $envelope = Flasher::title('Test Title')->success('Test message');

        $this->assertSame('Test Title', $envelope->getTitle());
    }

    public function testMessage(): void
    {
        $envelope = Flasher::message('Test message')->getEnvelope();

        $this->assertSame('Test message', $envelope->getMessage());
    }

    public function testType(): void
    {
        $envelope = Flasher::type('warning')->getEnvelope();

        $this->assertSame('warning', $envelope->getType());
    }

    public function testOptions(): void
    {
        $envelope = Flasher::options(['timeout' => 5000, 'position' => 'top-right'])->success('Test');

        $this->assertSame(['timeout' => 5000, 'position' => 'top-right'], $envelope->getOptions());
    }

    public function testOption(): void
    {
        $envelope = Flasher::option('timeout', 3000)->success('Test');

        $this->assertSame(3000, $envelope->getOptions()['timeout']);
    }

    public function testPriority(): void
    {
        $envelope = Flasher::priority(10)->success('Test');

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($priorityStamp);
        $this->assertSame(10, $priorityStamp->getPriority());
    }

    public function testHops(): void
    {
        $envelope = Flasher::hops(3)->success('Test');

        $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($hopsStamp);
        $this->assertSame(3, $hopsStamp->getAmount());
    }

    public function testKeep(): void
    {
        $envelope = Flasher::keep()->success('Test');

        $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($hopsStamp);
        $this->assertSame(2, $hopsStamp->getAmount());
    }

    public function testDelay(): void
    {
        $envelope = Flasher::delay(1000)->success('Test');

        $delayStamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');
        $this->assertNotNull($delayStamp);
        $this->assertSame(1000, $delayStamp->getDelay());
    }

    public function testHandler(): void
    {
        $envelope = Flasher::handler('toastr')->success('Test');

        $stamp = $envelope->get('Flasher\Prime\Stamp\PluginStamp');
        $this->assertNotNull($stamp);
        $this->assertSame('toastr', $stamp->getPlugin());
    }

    public function testContext(): void
    {
        $envelope = Flasher::context(['user_id' => 123])->success('Test');

        $contextStamp = $envelope->get('Flasher\Prime\Stamp\ContextStamp');
        $this->assertNotNull($contextStamp);
        $this->assertSame(['user_id' => 123], $contextStamp->getContext());
    }

    public function testWhenTrue(): void
    {
        $envelope = Flasher::when(true)->success('Conditional message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testWhenFalse(): void
    {
        $envelope = Flasher::when(false)->success('Conditional message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $stamp = $envelope->get('Flasher\Prime\Stamp\WhenStamp');
        $this->assertNotNull($stamp);
        $this->assertFalse($stamp->getCondition());
    }

    public function testWhenClosure(): void
    {
        $envelope = Flasher::when(fn () => true)->success('Closure conditional');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testUnlessTrue(): void
    {
        $envelope = Flasher::unless(true)->success('Unless message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $stamp = $envelope->get('Flasher\Prime\Stamp\UnlessStamp');
        $this->assertNotNull($stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testUnlessFalse(): void
    {
        $envelope = Flasher::unless(false)->success('Unless message');

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertSame('success', $envelope->getType());
    }

    public function testTranslate(): void
    {
        $envelope = Flasher::translate(['resource' => 'User'])->success('Test');

        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testWithStamps(): void
    {
        $stamp = new \Flasher\Prime\Stamp\PriorityStamp(5);
        $envelope = Flasher::with([$stamp])->success('Test');

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertNotNull($priorityStamp);
        $this->assertSame(5, $priorityStamp->getPriority());
    }

    public function testWithStamp(): void
    {
        $stamp = new \Flasher\Prime\Stamp\HopsStamp(3);
        $envelope = Flasher::with([$stamp])->success('Test');

        $hopsStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $this->assertNotNull($hopsStamp);
        $this->assertSame(3, $hopsStamp->getAmount());
    }

    public function testChainedMethods(): void
    {
        $envelope = Flasher::title('My Title')
            ->message('My Message')
            ->type('warning')
            ->option('timeout', 5000)
            ->priority(10)
            ->getEnvelope();

        $this->assertSame('My Title', $envelope->getTitle());
        $this->assertSame('My Message', $envelope->getMessage());
        $this->assertSame('warning', $envelope->getType());
        $this->assertSame(5000, $envelope->getOptions()['timeout']);
    }

    public function testFacadeReturnsBuilder(): void
    {
        $result = Flasher::title('Test');

        $this->assertInstanceOf(NotificationBuilderInterface::class, $result);
    }

    private function getFacadeAccessor(string $facadeClass): string
    {
        $reflection = new \ReflectionClass($facadeClass);
        $method = $reflection->getMethod('getFacadeAccessor');
        $method->setAccessible(true);

        return $method->invoke(null);
    }
}
