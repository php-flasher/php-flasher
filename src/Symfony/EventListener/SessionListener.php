<?php

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\ResponseManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class SessionListener implements EventSubscriberInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var FlasherInterface
     */
    private $flasher;

    /**
     * @var ResponseManagerInterface
     */
    private $renderer;

    /**
     * @param ConfigInterface          $config
     * @param FlasherInterface         $flasher
     * @param ResponseManagerInterface $renderer
     */
    public function __construct(ConfigInterface $config, FlasherInterface $flasher, ResponseManagerInterface $renderer)
    {
        $this->config = $config;
        $this->flasher = $flasher;
        $this->renderer = $renderer;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$event->isMasterRequest() || $request->isXmlHttpRequest() || true !== $this->config->get('auto_create_from_session')) {
            return;
        }

        $response = $event->getResponse();

        $mapping = $this->typesMapping();

        $readyToRender = false;

        foreach ($request->getSession()->getFlashBag()->all() as $type => $messages) {
            if (!isset($mapping[$type])) {
                continue;
            }

            foreach ($messages as $message) {
                $this->flasher->addFlash($mapping[$type], $message);
            }

            $readyToRender = true;
        }

        if (false === $readyToRender) {
            return;
        }

        $content = $response->getContent();

        $htmlResponse = $this->renderer->render(array(), 'html', array(
            'content' => $content,
        ));

        if (empty($htmlResponse)) {
            return;
        }

        $pos = strripos($content, '</html>');
        $content = substr($content, 0, $pos).$htmlResponse.substr($content, $pos);
        $response->setContent($content);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.response' => 'onKernelResponse',
        );
    }

    /**
     * @return array
     */
    private function typesMapping()
    {
        $mapping = array();

        foreach ($this->config->get('types_mapping', array()) as $type => $aliases) {
            if (is_int($type) && is_string($aliases)) {
                $type = $aliases;
            }

            foreach ((array)$aliases as $alias) {
                $mapping[$alias] = $type;
            }
        }

        return $mapping;
    }
}
