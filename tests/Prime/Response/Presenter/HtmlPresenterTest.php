<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Response\Presenter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Flasher\Prime\Response\Response;
use Flasher\Tests\Prime\TestCase;

final class HtmlPresenterTest extends TestCase
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
    options.push({"envelopes":[{"title":"PHPFlasher","message":"success message","type":"success","options":[],"metadata":[]},{"title":"yoeunes\/toastr","message":"warning message","type":"warning","options":[],"metadata":[]}],"scripts":[],"styles":[],"options":[],"context":[]});
    /** FLASHER_FLASH_BAG_PLACE_HOLDER **/
    addScriptAndRender(mergeOptions(...options));
    addRenderListener();
})(window, document);
</script>
JAVASCRIPT;

        $presenter = new HtmlPresenter();

        $this->assertEquals($response, $presenter->render(new Response($envelopes, [])));
    }

    public function testItRenderOnlyEnvelopesAsJsonObject(): void
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

        $response = '{"envelopes":[{"title":"PHPFlasher","message":"success message","type":"success","options":[],"metadata":[]},{"title":"yoeunes\/toastr","message":"warning message","type":"warning","options":[],"metadata":[]}],"scripts":[],"styles":[],"options":[],"context":{"envelopes_only":true}}';

        $presenter = new HtmlPresenter();

        $this->assertEquals($response, $presenter->render(new Response($envelopes, ['envelopes_only' => true])));
    }
}
