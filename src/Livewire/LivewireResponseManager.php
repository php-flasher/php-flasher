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
</script>
JAVASCRIPT;
    }
}
