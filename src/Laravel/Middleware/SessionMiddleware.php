<?php

namespace Flasher\Laravel\Middleware;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Presenter\Adapter\HtmlPresenter;
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
        if ($request->isXmlHttpRequest() || true !== $this->config->get('auto_create_from_session')) {
            return;
        }

        /**
         * @var Response $response
         */
        $response = $next($request);

        foreach ($this->typesMapping() as $alias => $type) {
            if (false === $request->session()->has($alias)) {
                continue;
            }

            $this->flasher->type($type, $request->session()->get($alias))->dispatch();
        }


        $content = $response->getContent();
        $pos     = strripos($content, '</body>');
        $content = substr($content, 0, $pos).$this->htmlPresenter->render().substr($content, $pos);
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
