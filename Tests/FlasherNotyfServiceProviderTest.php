<?php

namespace Flasher\Notyf\Laravel\Tests;

final class FlasherNotyfServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.factory.notyf'));
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

    public function testConfigNotyfInjectedInGlobalNotifyConfig()
    {
        $flasher = $this->app->make('flasher');

        $reflection = new \ReflectionClass($flasher);
        $property = $reflection->getProperty('config');
        $property->setAccessible(true);

        $config = $property->getValue($flasher);

        $this->assertArrayHasKey('notyf', $config->get('adapters'));

        $this->assertEquals(array(
            'notyf' => array('scripts' => array('jquery.js'), 'styles' => array('styles.css'), 'options' => array()),
        ), $config->get('adapters'));
    }
}
