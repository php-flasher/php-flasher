<?php

namespace Flasher\Symfony\Twig;

use Flasher\Prime\Response\ResponseManagerInterface;
use Twig\TwigFunction;

final class FlasherTwigExtension extends \Flasher\Symfony\Bridge\Twig\FlasherTwigExtension
{
    /**
     * @var ResponseManagerInterface
     */
    private $responseManager;

    public function __construct(ResponseManagerInterface $responseManager)
    {
        $this->responseManager = $responseManager;
    }

    public function getFlasherFunctions(): array
    {
        $options = array(
            'is_safe' => array('html'),
        );

        return array(
            new TwigFunction('flasher_render', array($this, 'flasherRender'), $options),
        );
    }

    /**
     * @return string
     */
    public function flasherRender(array $criteria = array()): string
    {
        return $this->responseManager->render($criteria);
    }
}
