<?php

declare(strict_types=1);

namespace Flasher\Livewire;

use Flasher\Prime\Config\ConfigInterface;

final class LivewireResponseManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function render(): string
    {
        $importScript = '';
        $rootScript = $this->config->get('root_script');
        if (!empty($rootScript)) {
            $importScript = <<<JAVASCRIPT
if (!window.Flasher && !document.querySelector('script[src="${rootScript}"]')) {
    var tag = document.createElement('script');

    tag.setAttribute('src', '${rootScript}');
    tag.setAttribute('type', 'text/javascript');

    document.body.appendChild(tag);
}
JAVASCRIPT;
        }

        return <<<JAVASCRIPT
<script type="text/javascript">
    ${importScript}

    window.addEventListener('flasher:render', function (event) {
        Flasher.getInstance().render(event.detail);
    });

    window.addEventListener('flasher:sweet_alert:promise', function (event) {
        var envelope = event.detail.envelope;
        var context = envelope.context;

        if (!context.livewire || !context.livewire.id) {
            return;
        }

        var detail = event.detail;
        if (envelope.livewire_context) {
            detail.context = envelope.livewire_context;
        }

        var component = context.livewire.id;

        Livewire.components.emitSelf(component, 'sweetAlertEvent', detail);

        var promise = event.detail.promise;
        if (promise.isConfirmed) {
            Livewire.components.emitSelf(component, 'sweetAlertConfirmed', detail);
        }

        if (promise.isDenied) {
            Livewire.components.emitSelf(component, 'sweetAlertDenied', detail);
        }

        if (promise.isDismissed) {
            Livewire.components.emitSelf(component, 'sweetAlertDismissed', detail);
        }
    }, false);
</script>
JAVASCRIPT;
    }
}
