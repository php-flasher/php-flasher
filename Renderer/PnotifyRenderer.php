<?php

namespace Flasher\PFlasher\Prime\Renderer;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Renderer\HasGlobalOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

class PnotifyRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasGlobalOptionsInterface
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
        $this->scripts = $config->get('adapters.pnotify.scripts', array());
        $this->styles  = $config->get('adapters.pnotify.styles', array());
        $this->options = $config->get('adapters.pnotify.options', array());
    }

    /**
     * @inheritDoc
     */
    public function render(Envelope $envelope)
    {
        $context = $envelope->getContext();
        $options = isset($context['options']) ? $context['options'] : array();

        $options['title'] = " " . $envelope->getTitle();
        $options['text'] = $envelope->getMessage();
        $options['type'] = $envelope->getType();

        return sprintf("new PNotify(%s);", json_encode($options));
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
        return sprintf('PNotify.defaults = %s;', json_encode($this->options));
    }
}
