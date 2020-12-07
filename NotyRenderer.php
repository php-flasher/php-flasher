<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

final class NotyRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasOptionsInterface
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
        $this->scripts = $config->get('adapters.noty.scripts', array());
        $this->styles  = $config->get('adapters.noty.styles', array());
        $this->options = $config->get('adapters.noty.options', array());
    }

    /**
     * @inheritDoc
     */
    public function render(Envelope $envelope)
    {
        $notification = $envelope->getNotification();
        $options = $envelope->getOptions();

        $options['text'] = $envelope->getMessage();
        $options['type'] = $envelope->getType();

        return sprintf("new Noty(%s).show();", json_encode($options));
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
        return sprintf('Noty.overrideDefaults(%s);', json_encode($this->options));
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'noty', 'Flasher\Noty\Prime\NotyFactory', 'Flasher\Noty\Prime\Noty'));
    }
}
