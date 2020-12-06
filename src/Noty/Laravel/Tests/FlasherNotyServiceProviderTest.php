<?php

namespace Flasher\Noty\Laravel\Tests;

class FlasherNotyServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.factory.noty'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');

        $reflection = new \ReflectionClass($flasher);
        $property = $reflection->getProperty('drivers');
        $property->setAccessible(true);

        $extensions = $property->getValue($flasher);

        $this->assertCount(1, $extensions);
        $this->assertInstanceOf('Flasher\Prime\Factory\FlasherFactoryInterface', $extensions[0]);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $flasher = $this->app->make('flasher');

        $reflection = new \ReflectionClass($flasher);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($flasher);

        $this->assertArrayHasKey('noty', $config->get('adapters'));

        $this->assertEquals(array(
            'noty' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
