<?php

namespace Flasher\Tests\Symfony;

use Flasher\Symfony\Bridge\Bridge;

class FlasherBundleTest extends TestCase
{
    public function testFlasherIntegration()
    {
        if (Bridge::versionCompare('2.1', '<')) {
            self::markTestSkipped('ErrorException: 8192: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/DependencyInjection/Compiler/RegisterKernelListenersPass.php line 39');
        }

        $container = $this->getContainer();

        $this->assertTrue($container->has('flasher'));
        $this->assertTrue($container->has('flasher.noty'));
        $this->assertTrue($container->has('flasher.notyf'));
        $this->assertTrue($container->has('flasher.pnotify'));
        $this->assertTrue($container->has('flasher.sweetalert'));
        $this->assertTrue($container->has('flasher.toastr'));

        $this->assertInstanceOf('Flasher\Prime\Flasher', $container->get('flasher'));
        $this->assertInstanceOf('Flasher\Noty\Prime\NotyFactory', $container->get('flasher.noty'));
        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $container->get('flasher.notyf'));
        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $container->get('flasher.pnotify'));
        $this->assertInstanceOf('Flasher\SweetAlert\Prime\SweetAlertFactory', $container->get('flasher.sweetalert'));
        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $container->get('flasher.toastr'));
    }
}
