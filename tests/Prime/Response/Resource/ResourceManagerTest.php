<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response\Resource;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Tests\Prime\TestCase;

final class ResourceManagerTest extends TestCase
{
    public function testItPopulateResponseFromResources(): void
    {
        $resourceManager = new ResourceManager('root_script.min.js', [
            'flasher' => [
                'scripts' => ['flasher.min.js'],
                'styles' => ['flasher.min.css'],
                'options' => ['timeout' => 2500, 'position' => 'center'],
            ],
            'toastr' => [
                'scripts' => ['toastr.min.js', 'jquery.min.js'],
                'styles' => ['toastr.min.css'],
                'options' => ['sounds' => false],
            ],
        ]);

        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, [
            new PluginStamp('flasher'),
            new CreatedAtStamp(new \DateTimeImmutable('2023-02-05 16:22:50')),
            new IdStamp('1111'),
        ]);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, [
            new PluginStamp('toastr'),
            new CreatedAtStamp(new \DateTimeImmutable('2023-02-05 16:22:50')),
            new IdStamp('2222'),
        ]);

        $response = new Response($envelopes, []);

        $response = $resourceManager->populateResponse($response);

        $this->assertEquals($envelopes, $response->getEnvelopes());
        $this->assertEquals('root_script.min.js', $response->getMainScript());
        $this->assertEquals(['flasher.min.js', 'toastr.min.js', 'jquery.min.js'], $response->getScripts());
        $this->assertEquals(['flasher.min.css', 'toastr.min.css'], $response->getStyles());
        $this->assertEquals([
            'toastr' => ['sounds' => false],
            'flasher' => ['timeout' => 2500, 'position' => 'center'],
        ], $response->getOptions());
    }
}
