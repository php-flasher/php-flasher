<?php

namespace Flasher\Pnotify\Laravel\Tests;

class NotifyPnotifyServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.factory'));
        $this->assertTrue($this->app->bound('flasher.factory.pnotify'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $manager = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass($manager);
        $property = $reflection->getProperty('drivers');
        $property->setAccessible(true);

        $extensions = $property->getValue($manager);

        $this->assertCount(1, $extensions);
        $this->assertInstanceOf('Flasher\Prime\FlasherInterface', $extensions['pnotify']);
    }

    public function testConfigPnotifyInjectedInGlobalNotifyConfig()
    {
        $manager = $this->app->make('flasher.factory');

        $reflection = new \ReflectionClass($manager);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($manager);

        $this->assertArrayHasKey('pnotify', $config->get('adapters'));

        $this->assertEquals(array(
            'pnotify' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
