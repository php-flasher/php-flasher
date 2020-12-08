<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

final class ToastrRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasOptionsInterface
{
    /**
     * @var array
     */
    private $scripts;

    /**
     * @var array
     */
    private $styles;

    /**
     * @var array
     */
    private $options;

    public function __construct(ConfigInterface $config)
    {
        $this->scripts = $config->get('adapters.toastr.scripts', array());
        $this->styles  = $config->get('adapters.toastr.styles', array());
        $this->options = $config->get('adapters.toastr.options', array());
    }

    /**
     * @inheritDoc
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * @inheritDoc
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'toastr', 'Flasher\Toastr\Prime\ToastrFactory', 'Flasher\Toastr\Prime\Toastr'));
    }
}
