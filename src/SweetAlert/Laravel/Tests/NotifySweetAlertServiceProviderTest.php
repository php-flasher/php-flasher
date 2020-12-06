<?php

namespace Flasher\SweetAlert\Laravel\Tests;

class NotifySweetAlertServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.factory'));
        $this->assertTrue($this->app->bound('flasher.factory.sweet_alert'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $manager = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass($manager);
        $property = $reflection->getProperty('drivers');
        $property->setAccessible(true);

        $extensions = $property->getValue($manager);

        $this->assertCount(1, $extensions);
        $this->assertInstanceOf('Flasher\Prime\FlasherInterface', $extensions['sweet_alert']);
    }

    public function testConfigSweetAlertInjectedInGlobalNotifyConfig()
    {
        $manager = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass($manager);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($manager);

        $this->assertArrayHasKey('sweet_alert', $config->get('adapters'));

        $this->assertEquals(array(
            'sweet_alert' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
