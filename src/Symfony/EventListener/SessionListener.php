<?php

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Renderer\RendererInterface;
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
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @param ConfigInterface   $config
     * @param FlasherInterface  $flasher
     * @param RendererInterface $htmlPresenter
     */
    public function __construct(ConfigInterface $config, FlasherInterface $flasher, RendererInterface $renderer)
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

        $rendereResponse = $this->renderer->render();
        if (empty($rendereResponse['notifications'])) {
            return;
        }

        $content = $response->getContent();

        $html = '';

        foreach ($rendereResponse['scripts'] as $script) {
            if (false === strpos($content, $script)) {
                $html .= sprintf('<script src="%s"></script>', $script).PHP_EOL;
            }
        }

        $notifications = json_encode($rendereResponse);

        $html .= <<<HTML
<script type="text/javascript">
if ("undefined" === typeof PHPFlasher) {
    alert("[PHPFlasher] not found, please include the '/bundles/flasher/flasher.js' file");
} else {
    PHPFlasher.render({$notifications});
}
</script>
HTML;

        $pos = strripos($content, '</html>');
        $content = substr($content, 0, $pos).$html.substr($content, $pos);
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
