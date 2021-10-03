<?php

namespace Flasher\Tests\Laravel\Config;

use Flasher\Laravel\Config\Config;
use Flasher\Tests\Laravel\TestCase;
use Illuminate\Foundation\Application;

final class ConfigTest extends TestCase
{
    public function testSimpleConfig()
    {
        $separator = $this->isLaravel4() ? '::' : '.';
        $config = new Config($this->app->make('config'), $separator);

        $this->assertEquals('template', $config->get('default'));
    }

    private function isLaravel4()
    {
        return 0 === strpos(Application::VERSION, '4.');
    }
}
