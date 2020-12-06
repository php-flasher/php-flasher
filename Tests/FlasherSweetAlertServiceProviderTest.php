<?php

namespace Flasher\SweetAlert\Laravel\Tests;

class FlasherSweetAlertServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.factory.sweet_alert'));
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

    public function testConfigSweetAlertInjectedInGlobalNotifyConfig()
    {
        $flasher = $this->app->make('flasher');

        $reflection = new \ReflectionClass($flasher);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($flasher);

        $this->assertArrayHasKey('sweet_alert', $config->get('adapters'));

        $this->assertEquals(array(
            'sweet_alert' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
