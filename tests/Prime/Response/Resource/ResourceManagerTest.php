<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Response\Resource;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Tests\Prime\TestCase;

class ResourceManagerTest extends TestCase
{
    /**
     * @return void
     */
    public function testItPopulateResponseFromResources()
    {
        $config = new Config(array(
            'default' => 'flasher',
            'root_script' => 'root_script.min.js',
        ));
        $resourceManager = new ResourceManager($config);

        $resourceManager->addScripts('flasher', array('flasher.min.js'));
        $resourceManager->addStyles('flasher', array('flasher.min.css'));
        $resourceManager->addOptions('flasher', array('timeout' => 2500, 'position' => 'center'));

        $resourceManager->addScripts('toastr', array('toastr.min.js', 'jquery.min.js'));
        $resourceManager->addStyles('toastr', array('toastr.min.css'));
        $resourceManager->addOptions('toastr', array('sounds' => false));

        $envelopes = array();

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, array(
            new HandlerStamp('flasher'),
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('1111'),
        ));

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, array(
            new HandlerStamp('toastr'),
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('2222'),
        ));

        $response = new Response($envelopes, array());

        $response = $resourceManager->buildResponse($response);

        $this->assertEquals($envelopes, $response->getEnvelopes());
        $this->assertEquals('root_script.min.js', $response->getRootScript());
        $this->assertEquals(array('toastr.min.js', 'jquery.min.js'), $response->getScripts());
        $this->assertEquals(array('toastr.min.css'), $response->getStyles());
        $this->assertEquals(array(
            'theme.flasher' => array('timeout' => 2500, 'position' => 'center'),
            'toastr' => array('sounds' => false),
        ), $response->getOptions());
        $this->assertEquals($config, $resourceManager->getConfig());
    }
}
