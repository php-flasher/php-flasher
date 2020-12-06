<?php

namespace Flasher\Notyf\Laravel\Tests;

class NotifyNotyfServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.factory'));
        $this->assertTrue($this->app->bound('flasher.factory.notyf'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $manager = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass($manager);
        $property = $reflection->getProperty('drivers');
        $property->setAccessible(true);

        $extensions = $property->getValue($manager);

        $this->assertCount(1, $extensions);
        $this->assertInstanceOf('Flasher\Prime\FlasherInterface', $extensions['notyf']);
    }

    public function testConfigNotyfInjectedInGlobalNotifyConfig()
    {
        $manager = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass($manager);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($manager);

        $this->assertArrayHasKey('notyf', $config->get('adapters'));

        $this->assertEquals(array(
            'notyf' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
