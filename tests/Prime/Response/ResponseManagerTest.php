<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response;

use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Resource\ResourceManagerInterface;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Tests\Prime\TestCase;

final class ResponseManagerTest extends TestCase
{
    public function testRenderSavedNotifications(): void
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, [
            new CreatedAtStamp(new \DateTimeImmutable('2023-02-05 16:22:50')),
            new IdStamp('1111'),
        ]);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, [
            new CreatedAtStamp(new \DateTimeImmutable('2023-02-06 16:22:50')),
            new IdStamp('2222'),
        ]);

        $resourceManager = $this->createMock(ResourceManagerInterface::class);
        $resourceManager->method('populateResponse')->willReturnArgument(0);

        $storageManager = $this->createMock(StorageManagerInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $responseManager = new ResponseManager($resourceManager, $storageManager, $eventDispatcher);

        $response = <<<JAVASCRIPT
<script type="text/javascript" class="flasher-js">
(function(window, document) {
    const merge = (first, second) => {
        if (Array.isArray(first) && Array.isArray(second)) {
            return [...first, ...second.filter(item => !first.includes(item))];
        }

        if (typeof first === 'object' && typeof second === 'object') {
            for (const [key, value] of Object.entries(second)) {
                first[key] = key in first ? { ...first[key], ...value } : value;
            }
            return first;
        }

        return undefined;
    };

    const mergeOptions = (...options) => {
        const result = {};

        options.forEach(option => {
            Object.entries(option).forEach(([key, value]) => {
                result[key] = key in result ? merge(result[key], value) : value;
            });
        });

        return result;
    };

    const renderCallback = (options) => {
        if(!window.flash) {
            throw new Error('Flasher is not loaded');
        }

        window.flash.render(options);
    };

    const render = (options) => {
        if (options instanceof Event) {
            options = options.detail;
        }

        if (['interactive', 'complete'].includes(document.readyState)) {
            renderCallback(options);
        } else {
            document.addEventListener('DOMContentLoaded', () => renderCallback(options));
        }
    };

    const addScriptAndRender = (options) => {
        const mainScript = '';

        if (window.flash || !mainScript || document.querySelector('script[src="' + mainScript + '"]')) {
            render(options);
        } else {
            const tag = document.createElement('script');
            tag.src = mainScript;
            tag.type = 'text/javascript';
            tag.onload = () => render(options);

            document.head.appendChild(tag);
        }
    };

    const addRenderListener = () => {
        if (1 === document.querySelectorAll('script.flasher-js').length) {
            document.addEventListener('flasher:render', render);
        }
    };

    const options = [];
    options.push({"envelopes":[],"scripts":[],"styles":[],"options":[],"context":[]});
    /** FLASHER_FLASH_BAG_PLACE_HOLDER **/
    addScriptAndRender(mergeOptions(...options));
    addRenderListener();
})(window, document);
</script>
JAVASCRIPT;

        $this->assertEquals($response, $responseManager->render('html'));
    }

    public function testItThrowsExceptionIfPresenterNotFound(): void
    {
        $this->setExpectedException('\InvalidArgumentException', 'Presenter [xml] not supported.');

        $resourceManager = $this->createMock(ResourceManagerInterface::class);
        $resourceManager->method('populateResponse')->willReturnArgument(0);

        $storageManager = $this->createMock(StorageManagerInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $responseManager = new ResponseManager($resourceManager, $storageManager, $eventDispatcher);
        $responseManager->render('xml');
    }
}
