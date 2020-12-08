<?php

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Renderer\Adapter\HtmlPresenter;
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
     * @var HtmlPresenter
     */
    private $htmlPresenter;

    /**
     * @param FlasherInterface $flasher
     * @param HtmlPresenter    $htmlPresenter
     */
    public function __construct(ConfigInterface $config, FlasherInterface $flasher, HtmlPresenter $htmlPresenter)
    {
        $this->config        = $config;
        $this->flasher       = $flasher;
        $this->htmlPresenter = $htmlPresenter;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$event->isMasterRequest() || $request->isXmlHttpRequest() || true !== $this->config->get('auto_create_from_session')) {
            return;
        }

        $response = $event->getResponse();

        $mapping = $this->typesMapping();

        foreach ($request->getSession()->getFlashBag()->all() as $type => $messages) {
            if (!isset($mapping[$type])) {
                continue;
            }

            foreach ($messages as $message) {
                $this->flasher->addFlash($mapping[$type], $message);
            }
        }

        $content = $response->getContent();
        $pos     = strripos($content, '</body>');
        $content = substr($content, 0, $pos).$this->htmlPresenter->render().substr($content, $pos);
        $response->setContent($content);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.response' => 'onKernelResponse'
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

            foreach ((array) $aliases as $alias) {
                $mapping[$alias] = $type;
            }
        }

        return $mapping;
    }
}
