<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Twig;

use Flasher\Prime\FlasherInterface;
use Flasher\Symfony\Bridge\Twig\FlasherTwigExtension as BaseFlasherTwigExtension;
use Twig\TwigFunction;

final class FlasherTwigExtension extends BaseFlasherTwigExtension
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFlasherFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new TwigFunction('flasher_render', array($this, 'render'), $options),
        );
    }

    /**
     * @param array<string, mixed> $criteria
     *
     * @return string
     */
    public function render(array $criteria = array())
    {
        return $this->flasher->render($criteria, 'html'); // @phpstan-ignore-line
    }
}
