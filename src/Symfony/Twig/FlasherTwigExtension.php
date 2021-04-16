<?php

namespace Flasher\Symfony\Twig;

use Flasher\Prime\Response\ResponseManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FlasherTwigExtension extends AbstractExtension
{
    /**
     * @var ResponseManagerInterface
     */
    private $responseManager;

    /**
     * @param ResponseManagerInterface $responseManager
     */
    public function __construct(ResponseManagerInterface $responseManager)
    {
        $this->responseManager = $responseManager;
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
        return $this->responseManager->render($criteria);
    }
}
