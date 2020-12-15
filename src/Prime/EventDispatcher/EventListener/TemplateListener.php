<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\Stamp\TemplateStamp;
use Flasher\Prime\Template\EngineInterface;

final class TemplateListener implements EventSubscriberInterface
{
    /**
     * @var EngineInterface
     */
    private $templateEngine;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     * @param EngineInterface $templateEngine
     */
    public function __construct(ConfigInterface $config, EngineInterface $templateEngine)
    {
        $this->config = $config;
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(ResponseEvent $event)
    {
        $envelopes = array();

        foreach ($event->getEnvelopes() as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();

            if ('template' !== $handler) {
                $envelopes[] = $envelope;
                continue;
            }

            $viewStamp = $envelope->get('Flasher\Prime\Stamp\TemplateStamp');
            $view = 'default';
            if (null !== $viewStamp) {
                $view = $viewStamp->getView();
            }

            $template = $this->config->get('adapters.template.views.'.$view);

            if (null === $template) {
                $default = $this->config->get('adapters.template.default');
                $template = $this->config->get('adapters.template.views.'.$default);
            }

            $compiled = $this->templateEngine->render($template, array(
                'envelope' => $envelope,
            ));

            $envelope->withStamp(new TemplateStamp($view, $compiled));
            $envelopes[] = $envelope;
        }

        $event->setEnvelopes($envelopes);
    }

    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\ResponseEvent';
    }
}
