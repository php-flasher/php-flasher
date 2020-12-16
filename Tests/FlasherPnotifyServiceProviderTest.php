<?php

namespace Flasher\Pnotify\Laravel\Tests;

class FlasherPnotifyServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.pnotify'));
        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $this->app->make('flasher.pnotify'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('pnotify');

        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js',
            ),
            'styles'  => array(
                'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css',
                'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css',
            ),
            'options' => array(
                'type'             => 'notice',
                'title'            => false,
                'titleTrusted'     => false,
                'text'             => false,
                'textTrusted'      => false,
                'styling'          => 'brighttheme',
                'icons'            => 'brighttheme',
                'mode'             => 'no-preference',
                'addClass'         => '',
                'addModalClass'    => '',
                'addModelessClass' => '',
                'autoOpen'         => true,
                'width'            => '360px',
                'minHeight'        => '16px',
                'maxTextHeight'    => '200px',
                'icon'             => true,
                'animation'        => 'fade',
                'animateSpeed'     => 'normal',
                'shadow'           => true,
                'hide'             => true,
                'delay'            => 5000,
                'mouseReset'       => true,
                'closer'           => true,
                'closerHover'      => true,
                'sticker'          => true,
                'stickerHover'     => true,
                'labels'           => array(
                    'close'   => 'Close',
                    'stick'   => 'Pin',
                    'unstick' => 'Unpin',
                ),
                'remove'           => true,
                'destroy'          => true,
            ),
        );

        $this->assertEquals($expected, $config->get('adapters.pnotify'));
    }
}
