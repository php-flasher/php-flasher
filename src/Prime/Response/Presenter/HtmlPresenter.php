<?php

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class HtmlPresenter implements PresenterInterface
{
    public function render(Response $response)
    {
        if (0 === count($response->getEnvelopes())) {
            return '';
        }

        $options = json_encode($response->toArray());

        $renderScript = "Flasher.getInstance().render(${options});";

        $rootScript = $response->getRootScript();
        if (empty($rootScript)) {
            return <<<JAVASCRIPT
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        ${renderScript}
    })
</script>
JAVASCRIPT;
        }


        return <<<JAVASCRIPT
<script type="text/javascript">
    flasherRender = function() {
      ${renderScript}
    }

    if (!window.Flasher && !document.querySelector('script[src="${rootScript}"]')) {
        var tag = document.createElement('script');

        tag.setAttribute('src', '${rootScript}');
        tag.setAttribute('type', 'text/javascript');
        tag.onload = flasherRender

        document.body.appendChild(tag);
    } else {
        document.addEventListener('DOMContentLoaded', function() {
          flasherRender()
        })
    }
</script>
JAVASCRIPT;
    }
}
