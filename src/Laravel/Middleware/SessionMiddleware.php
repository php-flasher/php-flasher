<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Middleware;

use Closure;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class SessionMiddleware
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    /**
     * @var array<string, string>
     */
    private $mapping;

    /**
     * @param array<string, string[]> $mapping
     */
    public function __construct(FlasherInterface $flasher, array $mapping = array())
    {
        $this->flasher = $flasher;
        $this->mapping = $this->flatMapping($mapping);
    }

    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if ($request->isXmlHttpRequest() || !$request->hasSession()) {
            return $response;
        }

        $content = $response->getContent() ?: '';
        $insertPlaceHolder = HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER;
        $insertPosition = strripos($content, $insertPlaceHolder);
        if (false === $insertPosition) {
            return $response;
        }

        $readyToRender = false;
        foreach ($this->mapping as $alias => $type) {
            if (false === $request->session()->has($alias)) {
                continue;
            }

            /** @var string $message */
            $message = $request->session()->get($alias);
            $this->flasher->addFlash((string) $type, $message);
            $readyToRender = true;
        }

        if (false === $readyToRender) {
            return $response;
        }

        $htmlResponse = $this->flasher->render(array(), 'html', array('envelopes_only' => true));
        if (empty($htmlResponse)) {
            return $response;
        }

        $content = substr($content, 0, $insertPosition).$htmlResponse.substr($content, $insertPosition + \strlen($insertPlaceHolder));
        $response->setContent($content);

        return $response;
    }

    /**
     * @param array<string, string[]> $mapping
     *
     * @return array<string, string>
     */
    private function flatMapping(array $mapping)
    {
        $flatMapping = array();

        foreach ($mapping as $type => $aliases) {
            foreach ($aliases as $alias) {
                $flatMapping[$alias] = $type;
            }
        }

        return $flatMapping;
    }
}
