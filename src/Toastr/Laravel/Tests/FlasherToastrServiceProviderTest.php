<?php

namespace Flasher\Toastr\Laravel\Tests;

class FlasherToastrServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.factory.toastr'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');

        $reflection = new \ReflectionClass($flasher);
        $property = $reflection->getProperty('drivers');
        $property->setAccessible(true);

        $extensions = $property->getValue($flasher);

        $this->assertCount(1, $extensions);
        $this->assertInstanceOf('Flasher\Prime\Factory\FactoryInterface', $extensions[0]);
    }

    public function testConfigToastrInjectedInGlobalNotifyConfig()
    {
        $flasher = $this->app->make('flasher');

        $reflection = new \ReflectionClass($flasher);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($flasher);

        $this->assertArrayHasKey('toastr', $config->get('adapters'));

        $this->assertEquals(array(
            'toastr' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
