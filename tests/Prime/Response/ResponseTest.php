<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Response;
use Flasher\Tests\Prime\TestCase;

final class ResponseTest extends TestCase
{
    public function testAddRootScriptToResponse(): void
    {
        $response = new Response([], []);

        $response->setMainScript('flasher.min.js');

        $this->assertEquals('flasher.min.js', $response->getMainScript());
    }

    public function testItAddsScriptToResponse(): void
    {
        $response = new Response([], []);

        $response->addScripts(['flasher.min.js', 'toastr.min.js']);
        $response->addScripts(['flasher.min.js', 'noty.min.js']);

        $this->assertEquals(['flasher.min.js', 'toastr.min.js', 'noty.min.js'], $response->getScripts());
    }

    public function testItAddsStylesToResponse(): void
    {
        $response = new Response([], []);

        $response->addStyles(['flasher.min.css', 'toastr.min.css']);
        $response->addStyles(['flasher.min.css', 'noty.min.css']);

        $this->assertEquals(['flasher.min.css', 'toastr.min.css', 'noty.min.css'], $response->getStyles());
    }

    public function testItAddsAdaptersOptionsToResponse(): void
    {
        $response = new Response([], []);

        $response->addOptions('flasher', ['position' => 'center', 'timeout' => 2500]);
        $response->addOptions('toastr', ['sounds' => false]);

        $this->assertEquals([
            'flasher' => ['position' => 'center', 'timeout' => 2500],
            'toastr' => ['sounds' => false],
        ], $response->getOptions());
    }

    public function testItTurnsTheResponseIntoAnArray(): void
    {
        $envelopes = [];

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

        $response = new Response($envelopes, []);
        $response->setMainScript('flasher.min.js');
        $response->addScripts(['noty.min.js', 'toastr.min.js']);
        $response->addStyles(['noty.min.css', 'toastr.min.css']);
        $response->addOptions('flasher', ['position' => 'center', 'timeout' => 2500]);
        $response->addOptions('toastr', ['sounds' => false]);

        $expected = [
            'envelopes' => [
                [
                    'notification' => [
                        'type' => 'success',
                        'title' => 'PHPFlasher',
                        'message' => 'success message',
                        'options' => [],
                    ],
                ],
                [
                    'notification' => [
                        'type' => 'warning',
                        'title' => 'yoeunes/toastr',
                        'message' => 'warning message',
                        'options' => [],
                    ],
                ],
            ],
            'scripts' => ['noty.min.js', 'toastr.min.js'],
            'styles' => ['noty.min.css', 'toastr.min.css'],
            'options' => [
                'flasher' => ['position' => 'center', 'timeout' => 2500],
                'toastr' => ['sounds' => false],
            ],
        ];

        $this->assertEquals($expected, $response->toArray());
    }
}
