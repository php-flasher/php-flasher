<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Support;

use Flasher\Laravel\EventListener\LivewireListener;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandlerInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Illuminate\Http\Request as LaravelRequest;
use Livewire\Component;
use Livewire\LivewireManager;
use Livewire\Mechanisms\HandleComponents\ComponentContext;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class LivewireListenerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInvocationWithConditionsToSkip(): void
    {
        $flasherMock = \Mockery::mock(FlasherInterface::class);
        $livewireManagerMock = \Mockery::mock(LivewireManager::class);
        $cspHandlerMock = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $requestMock = \Mockery::mock(LaravelRequest::class);

        $livewireListener = new LivewireListener($livewireManagerMock, $flasherMock, $cspHandlerMock, fn () => $requestMock);

        $componentMock = \Mockery::mock(Component::class);
        $contextMock = \Mockery::mock(ComponentContext::class);

        $livewireManagerMock->expects('isLivewireRequest')->andReturns(false);
        $flasherMock->expects('render')->never();

        $livewireListener->__invoke($componentMock, $contextMock);
    }

    public function testInvokeMethodDispatchNotifications(): void
    {
        $flasherMock = \Mockery::mock(FlasherInterface::class);
        $livewireManagerMock = \Mockery::mock(LivewireManager::class);
        $cspHandlerMock = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $requestMock = \Mockery::mock(LaravelRequest::class);

        $livewireListener = new LivewireListener($livewireManagerMock, $flasherMock, $cspHandlerMock, fn () => $requestMock);

        $componentMock = \Mockery::mock(Component::class);
        $contextMock = \Mockery::mock(ComponentContext::class);

        $livewireManagerMock->expects('isLivewireRequest')->andReturns(true);
        $cspHandlerMock->expects('getNonces')->andReturns(['csp_script_nonce' => null, 'csp_style_nonce' => null]);

        $componentMock->expects('getId')->andReturns('1');
        $componentMock->expects('getName')->andReturns('MyComponent');
        $contextMock->expects('addEffect');

        $flasherMock
            ->expects('render')
            ->andReturns(['envelopes' => [new Envelope(new Notification(), new IdStamp('1111'))]]);

        $livewireListener->__invoke($componentMock, $contextMock);
    }
}
