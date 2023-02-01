<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Response\Presenter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Response;
use Flasher\Tests\Prime\TestCase;

class ArrayPresenterTest extends TestCase
{
    /**
     * @return void
     */
    public function testArrayPresenter()
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

        $response = array(
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
            'scripts' => array(),
            'styles' => array(),
            'options' => array(),
        );

        $presenter = new ArrayPresenter();

        $this->assertEquals($response, $presenter->render(new Response($envelopes, array())));
    }
}
