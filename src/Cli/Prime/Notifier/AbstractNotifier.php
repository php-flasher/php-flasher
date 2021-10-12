<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\CliNotification;
use Flasher\Cli\Prime\System\Path;
use Flasher\Cli\Prime\System\Program;
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

        foreach ((array)$this->getBinaryPaths() as $path) {
            $path = Path::realpath($path);

            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    public function getTitle(Envelope $envelope)
    {
        $notification = $envelope->getNotification();

        if (method_exists($notification, 'getTitle') && null !== $notification->getTitle()) {
            return addslashes($notification->getTitle());
        }

        return addslashes($this->options['title']);
    }

    public function isEnabled()
    {
        return $this->options['enabled'];
    }

    /**
     * @param Envelope $envelope
     *
     * @return string
     */
    public function getIcon(Envelope $envelope)
    {
        $notification = $envelope->getNotification();
        if ($notification instanceof CliNotification && $notification->getIcon()) {
            return Path::realpath($notification->getIcon());
        }

        $type = $envelope->getType();

        if (isset($this->options['icons'][$type]) && file_exists($this->options['icons'][$type])) {
            return Path::realpath($this->options['icons'][$type]);
        }

        return Path::realpath(__DIR__.'/../Resources/icons/info.png');
    }

    public function playSound($type = null)
    {
        if ($this->options['mute']) {
            return;
        }

        \exec('paplay '.$this->getSound($type));
    }

    public function getSound($type)
    {
        if (isset($this->options['sounds'][$type]) && file_exists($this->options['sounds'][$type])) {
            return Path::realpath($this->options['sounds'][$type]);
        }

        return Path::realpath(__DIR__.'/../Resources/sounds/info.wav');
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
                NotificationInterface::TYPE_SUCCESS => Path::realpath(__DIR__.'/../Resources/icons/success.png'),
                NotificationInterface::TYPE_ERROR => Path::realpath(__DIR__.'/../Resources/icons/error.png'),
                NotificationInterface::TYPE_INFO => Path::realpath(__DIR__.'/../Resources/icons/info.png'),
                NotificationInterface::TYPE_WARNING => Path::realpath(__DIR__.'/../Resources/icons/warning.png'),
            ),
            'mute' => false,
            'sounds' => array(
                NotificationInterface::TYPE_SUCCESS => Path::realpath(__DIR__.'/../Resources/sounds/success.wav'),
                NotificationInterface::TYPE_ERROR => Path::realpath(__DIR__.'/../Resources/sounds/error.wav'),
                NotificationInterface::TYPE_INFO => Path::realpath(__DIR__.'/../Resources/sounds/info.wav'),
                NotificationInterface::TYPE_WARNING => Path::realpath(__DIR__.'/../Resources/sounds/warning.wav'),
            ),
        );

        $this->options = array_replace_recursive($default, $options);
    }
}
