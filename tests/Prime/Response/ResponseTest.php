<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Response;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Response;
use Flasher\Tests\Prime\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddRootScriptToResponse()
    {
        $response = new Response(array(), array());

        $response->setRootScript('flasher.min.js');

        $this->assertEquals('flasher.min.js', $response->getRootScript());
    }

    /**
     * @return void
     */
    public function testItAddsScriptToResponse()
    {
        $response = new Response(array(), array());

        $response->addScripts(array('flasher.min.js', 'toastr.min.js'));
        $response->addScripts(array('flasher.min.js', 'noty.min.js'));

        $this->assertEquals(array('flasher.min.js', 'toastr.min.js', 'noty.min.js'), $response->getScripts());
    }

    /**
     * @return void
     */
    public function testItAddsStylesToResponse()
    {
        $response = new Response(array(), array());

        $response->addStyles(array('flasher.min.css', 'toastr.min.css'));
        $response->addStyles(array('flasher.min.css', 'noty.min.css'));

        $this->assertEquals(array('flasher.min.css', 'toastr.min.css', 'noty.min.css'), $response->getStyles());
    }

    /**
     * @return void
     */
    public function testItAddsAdaptersOptionsToResponse()
    {
        $response = new Response(array(), array());

        $response->addOptions('flasher', array('position' => 'center', 'timeout' => 2500));
        $response->addOptions('toastr', array('sounds' => false));

        $this->assertEquals(array(
            'flasher' => array('position' => 'center', 'timeout' => 2500),
            'toastr' => array('sounds' => false),
        ), $response->getOptions());
    }

    /**
     * @return void
     */
    public function testItTurnsTheResponseIntoAnArray()
    {
        $envelopes = array();

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification);

        $response = new Response($envelopes, array());
        $response->setRootScript('flasher.min.js');
        $response->addScripts(array('noty.min.js', 'toastr.min.js'));
        $response->addStyles(array('noty.min.css', 'toastr.min.css'));
        $response->addOptions('flasher', array('position' => 'center', 'timeout' => 2500));
        $response->addOptions('toastr', array('sounds' => false));

        $expected = array(
            'envelopes' => array(
                array(
                    'notification' => array(
                        'type' => 'success',
                        'title' => 'PHPFlasher',
                        'message' => 'success message',
                        'options' => array(),
                    ),
                ),
                array(
                    'notification' => array(
                        'type' => 'warning',
                        'title' => 'yoeunes/toastr',
                        'message' => 'warning message',
                        'options' => array(),
                    ),
                ),
            ),
            'scripts' => array('noty.min.js', 'toastr.min.js'),
            'styles' => array('noty.min.css', 'toastr.min.css'),
            'options' => array(
                'flasher' => array('position' => 'center', 'timeout' => 2500),
                'toastr' => array('sounds' => false),
            ),
        );

        $this->assertEquals($expected, $response->toArray());
    }
}
