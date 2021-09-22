<?php

namespace Flasher\Console\Prime\Notifier;

use Flasher\Console\Prime\System\Program;
use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

abstract class AbstractNotifier implements NotifierInterface
{
    protected $options;

    public function __construct(array $options = array())
    {
        $this->configureOptions($options);
    }

    public function render(array $envelopes)
    {
        foreach ($envelopes as $envelope) {
            $this->renderEnvelope($envelope);
        }
    }

    abstract public function renderEnvelope(Envelope $envelope);

    public function isSupported()
    {
        return $this->options['is_supported'];
    }

    public function getPriority()
    {
        return $this->options['priority'];
    }

    public function getBinary()
    {
        return $this->options['binary'];
    }

    public function getBinaryPaths()
    {
        return $this->options['binary_paths'];
    }

    public function getProgram()
    {
        if (Program::exist($this->getBinary())) {
            return $this->getBinary();
        }

        foreach ((array) $this->getBinaryPaths() as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    public function getTitle()
    {
        return addslashes($this->options['title']);
    }

    public function isEnabled()
    {
        return $this->options['enabled'];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getIcon($type)
    {
        if (isset($this->options['icons'][$type]) && file_exists($this->options['icons'][$type])) {
            return $this->options['icons'][$type];
        }

        return __DIR__ . '/../Resources/icons/info.png';
    }

    public function playSound($type = null)
    {
        if ($this->options['mute']) {
            return;
        }

        \exec('paplay ' . $this->getSound($type));
    }

    public function getSound($type)
    {
        if (isset($this->options['sounds'][$type]) && file_exists($this->options['sounds'][$type])) {
            return $this->options['sounds'][$type];
        }

        return __DIR__ . '/../Resources/sounds/info.wav';
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'enabled' => true,
            'priority' => 0,
            'binary' => null,
            'binary_paths' => array(),
            'title' => 'PHPFlasher',
            'icons' => array(
                NotificationInterface::TYPE_SUCCESS => __DIR__ . '/../Resources/icons/success.png',
                NotificationInterface::TYPE_ERROR => __DIR__ . '/../Resources/icons/error.png',
                NotificationInterface::TYPE_INFO => __DIR__ . '/../Resources/icons/info.png',
                NotificationInterface::TYPE_WARNING => __DIR__ . '/../Resources/icons/warning.png',
            ),
            'mute' => false,
            'sounds' => array(
                NotificationInterface::TYPE_SUCCESS => __DIR__ . '/../Resources/sounds/success.wav',
                NotificationInterface::TYPE_ERROR => __DIR__ . '/../Resources/sounds/error.wav',
                NotificationInterface::TYPE_INFO => __DIR__ . '/../Resources/sounds/info.wav',
                NotificationInterface::TYPE_WARNING => __DIR__ . '/../Resources/sounds/warning.wav',
            ),
        );

        $this->options = array_replace_recursive($default, $options);
    }
}
