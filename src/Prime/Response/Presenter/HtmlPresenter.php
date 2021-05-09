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

        $scripts = $this->renderScripts($response->getScripts(), $response->getContext());
        $options = json_encode($response->toArray());

        return <<<CODE_SAMPLE
{$scripts}
<script type="text/javascript">
Flasher.getInstance().render({$options});
</script>
CODE_SAMPLE;
    }

    /**
     * @param string[] $scripts
     *
     * @return string
     */
    public function renderScripts($scripts, array $context)
    {
        $html = '';

        foreach ($scripts as $file) {
            if (empty($context['content']) || false === strpos($context['content'], $file)) {
                $html .= sprintf('<script src="%s"></script>', $file) . PHP_EOL;
            }
        }

        return $html;
    }
}
