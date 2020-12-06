<?php

namespace Flasher\Pnotify\Laravel\Tests;

class FlasherPnotifyServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.factory.pnotify'));
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

    public function testConfigPnotifyInjectedInGlobalNotifyConfig()
    {
        $manager = $this->app->make('flasher');

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
