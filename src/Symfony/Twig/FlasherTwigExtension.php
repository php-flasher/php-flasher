<?php

namespace Flasher\Symfony\Twig;

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
        return $this->renderer->render($criteria, array(
            'format' => 'html',
        ));
    }
}
