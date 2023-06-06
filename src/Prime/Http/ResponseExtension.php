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
        if (!$this->isRenderable($request, $response)) {
            return $response;
        }

        $content = $response->getContent() ?: '';
        if (!\is_string($content)) {
            return $response;
        }

        $placeHolders = array(
            HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER,
            HtmlPresenter::HEAD_END_PLACE_HOLDER,
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

        $htmlResponse = "\n".str_replace("\n", '', $htmlResponse)."\n";
        $offset = $alreadyRendered ? strlen(HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER) : 0;

        $content = substr($content, 0, $insertPosition).$htmlResponse.substr($content, $insertPosition + $offset);
        $response->setContent($content);

        return $response;
    }

    /**
     * @return bool
     */
    private function isRenderable(RequestInterface $request, ResponseInterface $response)
    {
        return !$request->isXmlHttpRequest()
            && $request->isHtmlRequestFormat()
            && !$response->isRedirection()
            && $response->isHtml()
            && !$response->isAttachment()
            && !$response->isJson();
    }
}
