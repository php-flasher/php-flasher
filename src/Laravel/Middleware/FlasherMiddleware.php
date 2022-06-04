<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Middleware;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class FlasherMiddleware
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @return Response
     */
    public function handle(Request $request, \Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if ($request->isXmlHttpRequest() || !$request->hasSession()) {
            return $response;
        }

        $content = $response->getContent() ?: '';

        $placeHolders = array(
            HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER,
            HtmlPresenter::BODY_END_PLACE_HOLDER,
        );

        foreach ($placeHolders as $insertPlaceHolder) {
            $insertPosition = strripos($content, $insertPlaceHolder);
            if (false !== $insertPosition) {
                break;
            }
        }

        if (false === $insertPosition) {
            return $response;
        }

        $alreadyRendered = HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER === $insertPlaceHolder;
        $htmlResponse = $this->flasher->render(array(), 'html', array('envelopes_only' => $alreadyRendered));

        if (empty($htmlResponse)) {
            return $response;
        }

        $content = substr($content, 0, $insertPosition).$htmlResponse.substr($content, $insertPosition + \strlen($insertPlaceHolder));
        $response->setContent($content);

        return $response;
    }
}
