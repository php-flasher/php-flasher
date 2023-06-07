<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response\Presenter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Response;
use Flasher\Tests\Prime\TestCase;

final class ArrayPresenterTest extends TestCase
{
    public function testArrayPresenter(): void
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

        $response = [
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
            'scripts' => [],
            'styles' => [],
            'options' => [],
        ];

        $presenter = new ArrayPresenter();

        $this->assertEquals($response, $presenter->render(new Response($envelopes, [])));
    }
}
