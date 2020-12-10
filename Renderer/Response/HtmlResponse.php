<?php

namespace Flasher\Prime\Renderer\Response;

final class HtmlResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    public function render(array $response, array $context = array())
    {
        if (empty($response['notifications'])) {
            return '';
        }

        $scripts = $this->renderScripts($response['scripts'], $context);
        $notifications = json_encode($response);

        return <<<HTML
{$scripts}
<script type="text/javascript">
if ("undefined" === typeof PHPFlasher) {
    alert("[PHPFlasher] not found, please include the '/bundles/flasher/flasher.js' file");
} else {
    PHPFlasher.render({$notifications});
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
