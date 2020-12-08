<?php

namespace Flasher\Symfony\Twig;

use Flasher\Prime\Renderer\Adapter\HtmlPresenter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FlasherTwigExtension extends AbstractExtension
{
    private $htmlPresenter;

    public function __construct(HtmlPresenter $htmlPresenter)
    {
        $this->htmlPresenter = $htmlPresenter;
    }

    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new TwigFunction('flasher_render', array($this, 'flasherRender'), $options),
        );
    }

    /**
     * @param string|array $criteria
     *
     * @return string
     */
    public function flasherRender($criteria = null)
    {
        return $this->htmlPresenter->render($criteria);
    }
}
