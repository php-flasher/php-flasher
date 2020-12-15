<?php

namespace Flasher\Prime\Renderer\Presenter;

final class HtmlPresenter extends AbstractPresenter
{
    /**
     * @inheritDoc
     */
    public function render(array $envelopes, array $context = array())
    {
        if (empty($envelopes)) {
            return '';
        }

        $scripts = $this->renderScripts($this->getScripts($envelopes), $context);
        $response = json_encode($this->toArray($envelopes));

        return <<<HTML
{$scripts}
<script type="text/javascript">
if ("undefined" === typeof PHPFlasher) {
    alert("[PHPFlasher] not found, please include the '/bundles/flasher/flasher.js' file");
} else {
    PHPFlasher.render({$response});
}
</script>
HTML;
    }

    /**
     * @param string[] $scripts
     * @param array    $context
     *
     * @return string
     */
    public function renderScripts($scripts, array $context)
    {
        $html = '';

        foreach ($scripts as $file) {
            if (empty($context['content']) || false === strpos($context['content'], $file)) {
                $html .= sprintf('<script src="%s"></script>', $file).PHP_EOL;
            }
        }

        return $html;
    }
}
