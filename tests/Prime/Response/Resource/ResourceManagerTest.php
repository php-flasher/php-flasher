<?php

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
        $config = new Config([
            'default' => 'flasher',
            'root_script' => 'root_script.min.js',
        ]);
        $resourceManager = new ResourceManager($config);

        $resourceManager->addScripts('flasher', ['flasher.min.js']);
        $resourceManager->addStyles('flasher', ['flasher.min.css']);
        $resourceManager->addOptions('flasher', ['timeout' => 2500, 'position' => 'center']);

        $resourceManager->addScripts('toastr', ['toastr.min.js', 'jquery.min.js']);
        $resourceManager->addStyles('toastr', ['toastr.min.css']);
        $resourceManager->addOptions('toastr', ['sounds' => false]);

        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, [
            new HandlerStamp('flasher'),
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('1111'),
        ]);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, [
            new HandlerStamp('toastr'),
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('2222'),
        ]);

        $response = new Response($envelopes, []);

        $response = $resourceManager->buildResponse($response);

        $this->assertEquals($envelopes, $response->getEnvelopes());
        $this->assertEquals('root_script.min.js', $response->getRootScript());
        $this->assertEquals(['flasher.min.js', 'toastr.min.js', 'jquery.min.js'], $response->getScripts());
        $this->assertEquals(['flasher.min.css', 'toastr.min.css'], $response->getStyles());
        $this->assertEquals([
            'theme.flasher' => ['timeout' => 2500, 'position' => 'center'],
            'toastr' => ['sounds' => false],
        ], $response->getOptions());
        $this->assertEquals($config, $resourceManager->getConfig());
    }
}
