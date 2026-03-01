<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\EventListener;

use Flasher\Laravel\EventListener\ThemeLivewireListener;
use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use PHPUnit\Framework\TestCase;

final class ThemeLivewireListenerTest extends TestCase
{
    private ThemeLivewireListener $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listener = new ThemeLivewireListener();
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
        $response .= '<script type="text/javascript" class="flasher-theme-livewire-js"></script>';

        $event = new ResponseEvent($response, 'html');

        ($this->listener)($event);

        $this->assertSame($response, $event->getResponse());
    }

    public function testInvokeInjectsLivewireScript(): void
    {
        $response = '<script type="text/javascript" class="flasher-js"></script>';

        $event = new ResponseEvent($response, 'html');

        ($this->listener)($event);

        $this->assertStringContainsString('flasher-theme-livewire-js', $event->getResponse());
        $this->assertStringContainsString('flasher:theme:click', $event->getResponse());
        $this->assertStringContainsString('theme:click', $event->getResponse());
        $this->assertStringContainsString("theme:' + themeName + ':click", $event->getResponse());
    }
}
