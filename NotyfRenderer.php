<?php

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

final class NotyfRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasOptionsInterface
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
        $this->scripts = $config->get('adapters.notyf.scripts', array());
        $this->styles  = $config->get('adapters.notyf.styles', array());
        $this->options = $config->get('adapters.notyf.options', array());
    }

    /**
     * @inheritDoc
     */
    public function render(Envelope $envelope)
    {
        $options = $envelope->getOptions();

        $options['message'] = $envelope->getMessage();
        $options['type'] = $envelope->getType();

        return sprintf("notyf.open(%s);", json_encode($options));
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
        return sprintf('if ("undefined" === typeof notyf) { var notyf = new Notyf(%s); }', json_encode($this->options));
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'notyf', 'Flasher\Notyf\Prime\NotyfFactory',
                                     'Flasher\Notyf\Prime\Pnotify'
        ));
    }
}
