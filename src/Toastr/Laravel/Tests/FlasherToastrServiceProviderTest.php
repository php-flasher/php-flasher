<?php

namespace Flasher\Toastr\Laravel\Tests;

class FlasherToastrServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.toastr'));
        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $this->app->make('flasher.toastr'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('toastr');

        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'toastr' => array(
                'scripts' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                    'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
                ),
                'styles'  => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
                ),
                'options' => array(
                    'closeButton'       => true,
                    'closeClass'        => 'toast-close-button',
                    'closeDuration'     => 300,
                    'closeEasing'       => 'swing',
                    'closeHtml'         => '<button><i class="icon-off"></i></button>',
                    'closeMethod'       => 'fadeOut',
                    'closeOnHover'      => true,
                    'containerId'       => 'toast-container',
                    'debug'             => false,
                    'escapeHtml'        => false,
                    'extendedTimeOut'   => 10000,
                    'hideDuration'      => 1000,
                    'hideEasing'        => 'linear',
                    'hideMethod'        => 'fadeOut',
                    'iconClass'         => 'toast-info',
                    'iconClasses'       => array(
                        'error'   => 'toast-error',
                        'info'    => 'toast-info',
                        'success' => 'toast-success',
                        'warning' => 'toast-warning',
                    ),
                    'messageClass'      => 'toast-message',
                    'newestOnTop'       => false,
                    'onHidden'          => null,
                    'onShown'           => null,
                    'positionClass'     => 'toast-top-right',
                    'preventDuplicates' => false,
                    'progressBar'       => true,
                    'progressClass'     => 'toast-progress',
                    'rtl'               => false,
                    'showDuration'      => 300,
                    'showEasing'        => 'swing',
                    'showMethod'        => 'fadeIn',
                    'tapToDismiss'      => true,
                    'target'            => 'body',
                    'timeOut'           => 5000,
                    'titleClass'        => 'toast-title',
                    'toastClass'        => 'toast',
                ),
            ),
        );

        $this->assertEquals($expected, $config->get('adapters'));
    }
}
