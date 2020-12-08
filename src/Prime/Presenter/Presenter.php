<?php

namespace Flasher\Prime\Presenter;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class Presenter implements PresenterInterface
{
    /**
     * @var StorageManagerInterface
     */
    private $storageManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param StorageManagerInterface  $storageManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param ConfigInterface          $config
     */
    public function __construct(StorageManagerInterface $storageManager, EventDispatcherInterface $eventDispatcher, ConfigInterface $config)
    {
        $this->storageManager = $storageManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->config = $config;
    }

    /**
     * @param string|array $criteria
     *
     * @return array
     */
    public function render($criteria = null)
    {
        $envelopes = $this->getEnvelopes($criteria);

        if (empty($envelopes)) {
            return array();
        }

        $response = array(
            'scripts'       => $this->getScripts($envelopes),
            'styles'        => $this->getStyles($envelopes),
            'options'       => $this->getOptions($envelopes),
            'notifications' => $this->getNotifications($envelopes),
        );

        $this->storageManager->remove($envelopes);

        return $response;
    }

    /**
     * @param string|array $criteria
     *
     * @return Envelope[]
     */
    protected function getEnvelopes($criteria = array())
    {
        $envelopes = $this->storageManager->all();

        $event = new FilterEvent($envelopes, $criteria);
        $this->eventDispatcher->dispatch($event);

        return $event->getEnvelopes();
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getStyles($envelopes)
    {
        $files = $this->config->get('styles', array());
        $handlers = array();

        foreach ($envelopes as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
            if (in_array($handler, $handlers)) {
                continue;
            }

            $handlers[] = $handler;
            $files = array_merge($files, $this->config->get(sprintf('adapters.%s.styles', $handler), array()));
        }

        return array_values(array_filter(array_unique($files)));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getScripts($envelopes)
    {
        $files     = $this->config->get('scripts', array());
        $handlers = array();

        foreach ($envelopes as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
            if (in_array($handler, $handlers)) {
                continue;
            }

            $handlers[] = $handler;
            $files = array_merge($files, $this->config->get(sprintf('adapters.%s.scripts', $handler), array()));
        }

        return array_values(array_filter(array_unique($files)));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getOptions($envelopes)
    {
        $options   = array();
        $handlers = array();

        foreach ($envelopes as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
            if (in_array($handler, $handlers)) {
                continue;
            }

            $handlers[] = $handler;
            $options[$handler] = $this->config->get(sprintf('adapters.%s.options', $handler), array());
        }

        return array_values(array_filter(array_unique($options)));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return array[]
     */
    public function getNotifications($envelopes)
    {
        $notifications = array();

        foreach ($envelopes as $index => $envelope) {
            $notifications[$index] = $envelope->toArray();
            $notifications[$index]['library'] = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
        }

        return $notifications;
    }
}
