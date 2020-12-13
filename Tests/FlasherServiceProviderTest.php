<?php

namespace Flasher\Laravel\Tests;

use Illuminate\View\Compilers\BladeCompiler;

final class FlasherServiceProviderTest extends TestCase
{
    public function testNotifyServiceExists()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.renderer'));
        $this->assertTrue($this->app->bound('flasher.storage'));
        $this->assertTrue($this->app->bound('flasher.storage_manager'));
        $this->assertTrue($this->app->bound('flasher.event_dispatcher'));
        $this->assertTrue($this->app->bound('flasher.filter'));
        $this->assertTrue($this->app->bound('flasher.config'));
    }

    public function testNotifyManagerGetConfig()
    {
        $notify = $this->app->make('flasher');

        $reflection = new \ReflectionClass(get_class($notify));
        $config = $reflection->getProperty('config');
        $config->setAccessible(true);

        $this->assertInstanceOf('Flasher\Prime\Config\ConfigInterface', $config->getValue($notify));
    }

    public function testBladeDirective()
    {
        /** @var BladeCompiler $blade */
        $blade = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();

        $this->assertEquals("<?php echo app('flasher.renderer')->render(array(), 'html'); ?>", $blade->compileString('@flasher_render()'));
    }
}
