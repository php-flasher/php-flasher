<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Response;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Tests\Prime\TestCase;

class ResponseManagerTest extends TestCase
{
    /**
     * @return void
     */
    public function testRenderSavedNotifications()
    {
        $envelopes = array();

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, array(
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('1111'),
        ));

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, array(
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('2222'),
        ));

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $responseManager = new ResponseManager(null, $storageManager);

        $response = <<<JAVASCRIPT
<script type="text/javascript" class="flasher-js">
(function() {
    var rootScript = '';
    var FLASHER_FLASH_BAG_PLACE_HOLDER = {};
    var options = mergeOptions({"envelopes":[{"notification":{"type":"success","message":"success message","title":"PHPFlasher","options":[]},"created_at":"2023-02-05 16:22:50","uuid":"1111","priority":0},{"notification":{"type":"warning","message":"warning message","title":"yoeunes\/toastr","options":[]},"created_at":"2023-02-05 16:22:50","uuid":"2222","priority":0}]}, FLASHER_FLASH_BAG_PLACE_HOLDER);

    function mergeOptions(first, second) {
        return {
            context: merge(first.context || {}, second.context || {}),
            envelopes: merge(first.envelopes || [], second.envelopes || []),
            options: merge(first.options || {}, second.options || {}),
            scripts: merge(first.scripts || [], second.scripts || []),
            styles: merge(first.styles || [], second.styles || []),
        };
    }

    function merge(first, second) {
        if (Array.isArray(first) && Array.isArray(second)) {
            return first.concat(second).filter(function(item, index, array) {
                return array.indexOf(item) === index;
            });
        }

        return Object.assign({}, first, second);
    }

    function renderOptions(options) {
        if(!window.hasOwnProperty('flasher')) {
            console.error('Flasher is not loaded');
            return;
        }

        requestAnimationFrame(function () {
            window.flasher.render(options);
        });
    }

    function render(options) {
        if ('loading' !== document.readyState) {
            renderOptions(options);

            return;
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderOptions(options);
        });
    }

    if (1 === document.querySelectorAll('script.flasher-js').length) {
        document.addEventListener('flasher:render', function (event) {
            render(event.detail);
        });
    }

    if (window.hasOwnProperty('flasher') || !rootScript || document.querySelector('script[src="' + rootScript + '"]')) {
        render(options);
    } else {
        var tag = document.createElement('script');
        tag.setAttribute('src', rootScript);
        tag.setAttribute('type', 'text/javascript');
        tag.onload = function () {
            render(options);
        };

        document.head.appendChild(tag);
    }
})();
</script>
JAVASCRIPT;

        $this->assertEquals($response, $responseManager->render());
    }

    /**
     * @return void
     */
    public function testItThrowsExceptionIfPresenterNotFound()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Presenter [xml] not supported.');

        $responseManager = new ResponseManager();
        $responseManager->render(array(), 'xml');
    }
}
