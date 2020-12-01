<?php

namespace Flasher\Laravel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * @param $app
     *
     * @return array
     */
    protected function getPackageProviders($app = null)
    {
        return array(
            'Flasher\Laravel\NotifyServiceProvider',
        );
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('session.driver', 'array');
    }
}
