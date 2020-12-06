<?php

namespace Flasher\Laravel\Tests;

use Illuminate\View\Compilers\BladeCompiler;

class NotifyServiceProviderTest extends TestCase
{
    public function test_notify_service_exists()
    {
        $this->assertTrue($this->app->bound('flasher.factory'));
    }

    public function test_notify_manager_get_config()
    {
        $notify = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass(get_class($notify));
        $config = $reflection->getProperty('config');
        $config->setAccessible(true);

        $this->assertInstanceOf('Flasher\Prime\Config\ConfigInterface', $config->getValue($notify));
    }

    public function test_blade_directive()
    {
        /** @var BladeCompiler $blade */
        $blade = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();

        $this->assertEquals("<?php echo app('flasher.presenter.html')->render(); ?>", $blade->compileString('@notify_render'));
    }
}
