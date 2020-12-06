<?php

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

final class SweetAlertRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasOptionsInterface
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
        $this->scripts = $config->get('adapters.sweet_alert.scripts', array());
        $this->styles  = $config->get('adapters.sweet_alert.styles', array());
        $this->options = $config->get('adapters.sweet_alert.options', array());
    }

    /**
     * @inheritDoc
     */
    public function render(Envelope $envelope)
    {
        $options = $envelope->getOptions();

        $options['text'] = $envelope->getMessage();
        $options['icon'] = $envelope->getType();

        if (!empty($options['imageUrl'])) {
            unset($options['icon']);
        }

        return sprintf("SwalToast.fire(%s);", json_encode($options));
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
        return sprintf('var SwalToast = Swal.mixin(%s);', json_encode($this->options));
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'sweet_alert', 'Flasher\SweetAlert\Prime\SweetAlertFactory', 'Flasher\SweetAlert\Prime\SweetAlert'));
    }
}
