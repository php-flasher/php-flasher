<?php

namespace Flasher\Notyf\Laravel\Tests;

class FlasherNotyfServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.notyf'));
        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $this->app->make('flasher.notyf'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('notyf');

        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'notyf' => array(
                'scripts' => array(
                    'https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js',
                ),
                'styles'  => array(
                    'https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css',
                ),
                'options' => array(
                    'duration'    => 5000,
                    'ripple'      => true,
                    'position'    => array(
                        'x' => 'right',
                        'y' => 'top',
                    ),
                    'dismissible' => false,
                    'types'       => array(
                        array(
                            'type'            => 'success',
                            'className'       => 'notyf__toast--success',
                            'backgroundColor' => '#3dc763',
                            'icon'            => array(
                                'className' => 'notyf__icon--success',
                                'tagName'   => 'i',
                            ),
                        ),
                        array(
                            'type'            => 'error',
                            'className'       => 'notyf__toast--error',
                            'backgroundColor' => '#ed3d3d',
                            'icon'            => array(
                                'className' => 'notyf__icon--error',
                                'tagName'   => 'i',
                            ),
                        ),
                        array(
                            'type'            => 'info',
                            'className'       => 'notyf__toast--info',
                            'backgroundColor' => '#5784E5',
                            'icon'            => false,
                        ),
                        array(
                            'type'            => 'warning',
                            'className'       => 'notyf__toast--warning',
                            'backgroundColor' => '#E3A008',
                            'icon'            => false,
                        ),
                    ),
                ),
            ),
        );

        $this->assertEquals($expected, $config->get('adapters'));
    }
}
