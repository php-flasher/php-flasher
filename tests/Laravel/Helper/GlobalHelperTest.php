<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Helper;

use Flasher\Noty\Prime\NotyInterface;
use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use Flasher\Tests\Laravel\TestCase;
use Flasher\Toastr\Prime\ToastrInterface;

final class GlobalHelperTest extends TestCase
{
    public function testFlashReturnsFactoryWithNoArgs(): void
    {
        $result = flash();

        $this->assertInstanceOf(FlasherInterface::class, $result);
    }

    public function testFlashReturnsEnvelopeWithMessage(): void
    {
        $result = flash('Test message');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
        $this->assertSame('success', $result->getType());
    }

    public function testFlashWithCustomType(): void
    {
        $result = flash('Error message', 'error');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('error', $result->getType());
    }

    public function testFlashWithOptions(): void
    {
        $result = flash('Test', 'warning', ['timeout' => 5000]);

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('warning', $result->getType());
        $this->assertSame(['timeout' => 5000], $result->getOptions());
    }

    public function testFlashWithTitle(): void
    {
        $result = flash('Test message', 'info', [], 'My Title');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('info', $result->getType());
        $this->assertSame('My Title', $result->getTitle());
    }

    public function testToastrReturnsFactoryWithNoArgs(): void
    {
        $result = toastr();

        $this->assertInstanceOf(ToastrInterface::class, $result);
    }

    public function testToastrReturnsEnvelopeWithMessage(): void
    {
        $result = toastr('Test message');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
        $this->assertSame('success', $result->getType());
    }

    public function testToastrWithCustomType(): void
    {
        $result = toastr('Error message', 'error');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('error', $result->getType());
    }

    public function testNotyReturnsFactoryWithNoArgs(): void
    {
        $result = noty();

        $this->assertInstanceOf(NotyInterface::class, $result);
    }

    public function testNotyReturnsEnvelopeWithMessage(): void
    {
        $result = noty('Test message');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
        $this->assertSame('success', $result->getType());
    }

    public function testNotyWithCustomType(): void
    {
        $result = noty('Warning message', 'warning');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('warning', $result->getType());
    }

    public function testNotyfReturnsFactoryWithNoArgs(): void
    {
        $result = notyf();

        $this->assertInstanceOf(NotyfInterface::class, $result);
    }

    public function testNotyfReturnsEnvelopeWithMessage(): void
    {
        $result = notyf('Test message');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
        $this->assertSame('success', $result->getType());
    }

    public function testNotyfWithCustomType(): void
    {
        $result = notyf('Error message', 'error');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('error', $result->getType());
    }

    public function testSweetalertReturnsFactoryWithNoArgs(): void
    {
        $result = sweetalert();

        $this->assertInstanceOf(SweetAlertInterface::class, $result);
    }

    public function testSweetalertReturnsEnvelopeWithMessage(): void
    {
        $result = sweetalert('Test message');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
        $this->assertSame('success', $result->getType());
    }

    public function testSweetalertWithCustomType(): void
    {
        $result = sweetalert('Question?', 'question');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('question', $result->getType());
    }
}
