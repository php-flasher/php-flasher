<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

final class ToastrRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasOptionsInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

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
        $this->config  = $config;
        $this->scripts = $config->get('adapters.toastr.scripts', array());
        $this->styles  = $config->get('adapters.toastr.styles', array());
        $this->options = $config->get('adapters.toastr.options', array());
    }

    /**
     * @inheritDoc
     */
    public function render(Envelope $envelope)
    {
        $notification = $envelope->getNotification();
        $options = $envelope->getOptions();

        return sprintf(
            "toastr.%s('%s', '%s', %s);",
            $notification->getType(),
            $notification->getMessage(),
            $notification->getTitle(),
            json_encode($options)
        );
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

    public function renderOptions()
    {
        return sprintf('toastr.options = %s;', json_encode($this->options));
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'toastr', 'Flasher\Toastr\Prime\ToastrFactory', 'Flasher\Toastr\Prime\Toastr'));
    }
}
