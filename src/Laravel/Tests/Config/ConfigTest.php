<?php

namespace Flasher\Laravel\Tests\Config;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\Tests\TestCase;
use Illuminate\Foundation\Application;

final class ConfigTest extends TestCase
{
    public function testSimpleConfig()
    {
        $separator = $this->isLaravel4() ? '::' : '.';
        $config = new Config($this->app->make('config'), $separator);

        $this->assertEquals('template', $config->get('default'));
        $this->assertSame(array(
            'template' => array(
                'default'   => 'tailwindcss',
                'templates' => array(
                    'tailwindcss'    => array(
                        'view'   => 'flasher::tailwindcss',
                        'styles' => array(
                            'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
                        ),
                    ),
                    'tailwindcss_bg' => array(
                        'view'   => 'flasher::tailwindcss_bg',
                        'styles' => array(
                            'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
                        ),
                    ),
                    'bootstrap'      => array(
                        'view'   => 'flasher::bootstrap',
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css',
                        ),
                    ),
                ),
                'scripts'   => array(
                    '/vendor/flasher/flasher-template.js',
                ),
                'styles'    => array(),
                'options'   => array(
                    'timeout'  => 5000,
                    'position' => 'top-right',
                ),
            ),
        ), $config->get('adapters', array()));
    }

    private function isLaravel4()
    {
        return 0 === strpos(Application::VERSION, '4.');
    }
}
