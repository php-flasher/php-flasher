<?php

declare(strict_types=1);

namespace Flasher\Tests\Toastr\Laravel;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Toastr\Laravel\LivewireListener;
use PHPUnit\Framework\TestCase;

final class LivewireListenerTest extends TestCase
{
    private LivewireListener $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listener = new LivewireListener();
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(ResponseEvent::class, $this->listener->getSubscribedEvents());
    }

    public function testInvokeSkipsNonHtmlPresenter(): void
    {
        $event = new ResponseEvent('', 'json');

        ($this->listener)($event);

        $this->assertSame('', $event->getResponse());
    }

    public function testInvokeSkipsResponseWithoutFlasherScript(): void
    {
        $event = new ResponseEvent('<html><body>No flasher</body></html>', 'html');

        ($this->listener)($event);

        $this->assertSame('<html><body>No flasher</body></html>', $event->getResponse());
    }

    public function testInvokeSkipsDuplicateInjection(): void
    {
        $response = '<script type="text/javascript" class="flasher-js"></script>';
        $response .= '<script type="text/javascript" class="flasher-toastr-livewire-js"></script>';

        $event = new ResponseEvent($response, 'html');

        ($this->listener)($event);

        $this->assertSame($response, $event->getResponse());
    }

    public function testInvokeInjectsLivewireScript(): void
    {
        $response = '<script type="text/javascript" class="flasher-js"></script>';

        $event = new ResponseEvent($response, 'html');

        ($this->listener)($event);

        $this->assertStringContainsString('flasher-toastr-livewire-js', $event->getResponse());
        $this->assertStringContainsString('flasher:toastr:show', $event->getResponse());
        $this->assertStringContainsString('flasher:toastr:click', $event->getResponse());
        $this->assertStringContainsString('flasher:toastr:close', $event->getResponse());
        $this->assertStringContainsString('flasher:toastr:hidden', $event->getResponse());
    }
}
