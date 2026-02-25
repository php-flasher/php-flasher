<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Helper;

use Flasher\Tests\Laravel\TestCase;

final class NamespacedHelperTest extends TestCase
{
    public function testPrimeFlashFunctionExists(): void
    {
        $this->assertTrue(\function_exists('Flasher\Prime\flash'));
    }

    public function testPrimeFlashReturnsFactoryWithNoArgs(): void
    {
        $result = \Flasher\Prime\flash();

        $this->assertInstanceOf(\Flasher\Prime\FlasherInterface::class, $result);
    }

    public function testPrimeFlashReturnsEnvelopeWithMessage(): void
    {
        $result = \Flasher\Prime\flash('Test message');

        $this->assertInstanceOf(\Flasher\Prime\Notification\Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
    }

    public function testToastrFunctionExists(): void
    {
        $this->assertTrue(\function_exists('Flasher\Toastr\Prime\toastr'));
    }

    public function testToastrReturnsFactoryWithNoArgs(): void
    {
        $result = \Flasher\Toastr\Prime\toastr();

        $this->assertInstanceOf(\Flasher\Toastr\Prime\ToastrInterface::class, $result);
    }

    public function testToastrReturnsEnvelopeWithMessage(): void
    {
        $result = \Flasher\Toastr\Prime\toastr('Test message');

        $this->assertInstanceOf(\Flasher\Prime\Notification\Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
    }

    public function testNotyFunctionExists(): void
    {
        $this->assertTrue(\function_exists('Flasher\Noty\Prime\noty'));
    }

    public function testNotyReturnsFactoryWithNoArgs(): void
    {
        $result = \Flasher\Noty\Prime\noty();

        $this->assertInstanceOf(\Flasher\Noty\Prime\NotyInterface::class, $result);
    }

    public function testNotyReturnsEnvelopeWithMessage(): void
    {
        $result = \Flasher\Noty\Prime\noty('Test message');

        $this->assertInstanceOf(\Flasher\Prime\Notification\Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
    }

    public function testNotyfFunctionExists(): void
    {
        $this->assertTrue(\function_exists('Flasher\Notyf\Prime\notyf'));
    }

    public function testNotyfReturnsFactoryWithNoArgs(): void
    {
        $result = \Flasher\Notyf\Prime\notyf();

        $this->assertInstanceOf(\Flasher\Notyf\Prime\NotyfInterface::class, $result);
    }

    public function testNotyfReturnsEnvelopeWithMessage(): void
    {
        $result = \Flasher\Notyf\Prime\notyf('Test message');

        $this->assertInstanceOf(\Flasher\Prime\Notification\Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
    }

    public function testSweetalertFunctionExists(): void
    {
        $this->assertTrue(\function_exists('Flasher\SweetAlert\Prime\sweetalert'));
    }

    public function testSweetalertReturnsFactoryWithNoArgs(): void
    {
        $result = \Flasher\SweetAlert\Prime\sweetalert();

        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlertInterface::class, $result);
    }

    public function testSweetalertReturnsEnvelopeWithMessage(): void
    {
        $result = \Flasher\SweetAlert\Prime\sweetalert('Test message');

        $this->assertInstanceOf(\Flasher\Prime\Notification\Envelope::class, $result);
        $this->assertSame('Test message', $result->getMessage());
    }
}
