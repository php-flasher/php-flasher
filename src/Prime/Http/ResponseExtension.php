<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;

final class ResponseExtension
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
     * @return ResponseInterface
     */
    public function render(RequestInterface $request, ResponseInterface $response)
    {
        if ($request->isXmlHttpRequest()
            || !$request->hasSession()
            || $response->isRedirection()
            || $response->isJson()) {
            return $response;
        }

        $content = $response->getContent() ?: '';
        if (!\is_string($content)) {
            return $response;
        }

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
