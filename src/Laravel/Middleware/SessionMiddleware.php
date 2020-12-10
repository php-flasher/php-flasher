<?php

namespace Flasher\Laravel\Middleware;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Renderer\RendererInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class SessionMiddleware
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
     * @param RendererInterface $renderer
     */
    public function __construct(ConfigInterface $config, FlasherInterface $flasher, RendererInterface $renderer)
    {
        $this->config = $config;
        $this->flasher = $flasher;
        $this->renderer = $renderer;
    }

    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        /**
         * @var Response $response
         */
        $response = $next($request);

        if ($request->isXmlHttpRequest() || true !== $this->config->get('auto_create_from_session')) {
            return $response;
        }

        $readyToRender = false;

        foreach ($this->typesMapping() as $alias => $type) {
            if (false === $request->session()->has($alias)) {
                continue;
            }

            $this->flasher->addFlash($type, $request->session()->get($alias));

            $readyToRender = true;
        }

        if (false === $readyToRender) {
            return $response;
        }

        $content = $response->getContent();

        $htmlResponse = $this->renderer->render(array(),
            array(
                'format'  => 'html',
                'content' => $content,
            ));

        if (empty($htmlResponse)) {
            return $response;
        }

        $pos = strripos($content, '</body>');
        $content = substr($content, 0, $pos).$htmlResponse.substr($content, $pos);
        $response->setContent($content);

        return $response;
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
