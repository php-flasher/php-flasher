<?php

namespace Flasher\Laravel\Tests\Config;

use Illuminate\Foundation\Application;
use Flasher\Laravel\Config\Config;
use Flasher\Laravel\Tests\TestCase;

final class ConfigTest extends TestCase
{
    public function testSimpleConfig()
    {
        $separator = $this->isLaravel4() ? '::' : '.';
        $config = new Config($this->app->make('config'), $separator);

        $this->assertEquals('toastr', $config->get('default'));
        $this->assertSame(array(), $config->get('adapters', array()));
    }

    private function isLaravel4()
    {
        return 0 === strpos(Application::VERSION, '4.');
    }
}
