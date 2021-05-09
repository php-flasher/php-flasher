<?php

namespace Flasher\Laravel\Tests;

use Illuminate\View\Compilers\BladeCompiler;

final class FlasherServiceProviderTest extends TestCase
{
    public function testNotifyServiceExists()
    {
        $this->assertInstanceOf('Flasher\Laravel\Config\Config', $this->app->make('flasher.config'));
        $this->assertInstanceOf('Flasher\Prime\Flasher', $this->app->make('flasher'));
        $this->assertInstanceOf('Flasher\Prime\Response\ResponseManager', $this->app->make('flasher.response_manager'));
        $this->assertInstanceOf(
            'Flasher\Prime\Response\Resource\ResourceManager',
            $this->app->make('flasher.resource_manager')
        );
        $this->assertInstanceOf('Flasher\Laravel\Storage\Storage', $this->app->make('flasher.storage'));
        $this->assertInstanceOf('Flasher\Prime\Storage\StorageManager', $this->app->make('flasher.storage_manager'));
        $this->assertInstanceOf(
            'Flasher\Prime\EventDispatcher\EventDispatcher',
            $this->app->make('flasher.event_dispatcher')
        );
        $this->assertInstanceOf('Flasher\Prime\Filter\Filter', $this->app->make('flasher.filter'));
    }

    public function testBladeDirective()
    {
        /** @var BladeCompiler $blade */
        $blade = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();

        $this->assertSame(
            "<?php echo app('flasher.response_manager')->render(array(), 'html'); ?>",
            $blade->compileString('@flasher_render')
        );
        $this->assertSame(
            "<?php echo app('flasher.response_manager')->render(array(), 'html'); ?>",
            $blade->compileString('@flasher_render()')
        );
        $this->assertSame(
            "<?php echo app('flasher.response_manager')->render(array(), 'html'); ?>",
            $blade->compileString('@flasher_render(array())')
        );
        $this->assertSame(
            "<?php echo app('flasher.response_manager')->render(array(\"priority\" => array(\"min\" => 4, \"max\" => 5)), 'html'); ?>",
            $blade->compileString('@flasher_render(array("priority" => array("min" => 4, "max" => 5)))')
        );
    }
}
