<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

final class FlasherBundleTest extends TestCase
{
    public function testFlasherIntegration(): void
    {
        $container = $this->getContainer();

        $this->assertTrue($container->has('flasher'));
        $this->assertTrue($container->has('flasher.noty'));
        $this->assertTrue($container->has('flasher.notyf'));
        $this->assertTrue($container->has('flasher.sweetalert'));
        $this->assertTrue($container->has('flasher.toastr'));

        $this->assertInstanceOf(\Flasher\Prime\Flasher::class, $container->get('flasher'));
        $this->assertInstanceOf(\Flasher\Noty\Prime\Noty::class, $container->get('flasher.noty'));
        $this->assertInstanceOf(\Flasher\Notyf\Prime\Notyf::class, $container->get('flasher.notyf'));
        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlert::class, $container->get('flasher.sweetalert'));
        $this->assertInstanceOf(\Flasher\Toastr\Prime\Toastr::class, $container->get('flasher.toastr'));
    }
}
