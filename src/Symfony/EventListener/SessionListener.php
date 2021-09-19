<?php

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\ResponseManagerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class SessionListener
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
    private $responseManager;

    public function __construct(
        ConfigInterface $config,
        FlasherInterface $flasher,
        ResponseManagerInterface $responseManager
    ) {
        $this->config = $config;
        $this->flasher = $flasher;
        $this->responseManager = $responseManager;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$this->isMainRequest($event)
            || $request->isXmlHttpRequest()
            || true !== $this->config->get('auto_create_from_session')) {
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

        $htmlResponse = $this->responseManager->render(array(), 'html');
        if (empty($htmlResponse)) {
            return;
        }

        $content = $response->getContent();
        $pos = strripos($content, '</html>');
        $content = substr($content, 0, $pos).$htmlResponse.substr($content, $pos);
        $response->setContent($content);
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

            foreach ((array) $aliases as $alias) {
                $mapping[$alias] = $type;
            }
        }

        return $mapping;
    }

    private function isMainRequest(ResponseEvent $event)
    {
        if (method_exists($event, 'isMasterRequest')) {
            return $event->isMasterRequest();
        }

        return $event->isMainRequest();
    }
}
