<?php

namespace Flasher\Symfony\Twig;

use Flasher\Prime\Renderer\Adapter\HtmlPresenter;
use Flasher\Prime\Renderer\RendererInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FlasherTwigExtension extends AbstractExtension
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new TwigFunction('flasher_render', array($this, 'flasherRender'), $options),
        );
    }

    /**
     * @param array $criteria
     *
     * @return string
     */
    public function flasherRender(array $criteria = array())
    {
        $response = $this->renderer->render($criteria);

        if (empty($response['notifications'])) {
            return '';
        }

        $scripts = $this->renderScripts($response['scripts']);
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
     *
     * @return string
     */
    public function renderScripts($scripts)
    {
        $html = '';

        foreach ($scripts as $file) {
            $html .= sprintf('<script src="%s"></script>', $file).PHP_EOL;
        }

        return $html;
    }
}
