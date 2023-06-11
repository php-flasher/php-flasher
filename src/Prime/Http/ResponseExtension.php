<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;

final class ResponseExtension
{
    public function __construct(private readonly FlasherInterface $flasher)
    {
    }

    public function render(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (! $this->isRenderable($request, $response)) {
            return $response;
        }

        $content = $response->getContent() ?: '';
        if (! \is_string($content)) {
            return $response;
        }

        $placeHolders = [
            HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER,
            HtmlPresenter::HEAD_END_PLACE_HOLDER,
            HtmlPresenter::BODY_END_PLACE_HOLDER,
        ];

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
        $htmlResponse = $this->flasher->render('html', [], ['envelopes_only' => $alreadyRendered]);

        if (empty($htmlResponse)) {
            return $response;
        }

        if ($alreadyRendered) {
            $htmlResponse = sprintf('options.push(%s);', $htmlResponse);
        }

        // $htmlResponse = "\n".str_replace("\n", '', (string) $htmlResponse)."\n";
        $htmlResponse .= "\n";

        $content = substr($content, 0, $insertPosition).$htmlResponse.substr($content, $insertPosition);
        $response->setContent($content);

        return $response;
    }

    private function isRenderable(RequestInterface $request, ResponseInterface $response): bool
    {
        if ($request->isXmlHttpRequest()) {
            return false;
        }

        if (! $request->isHtmlRequestFormat()) {
            return false;
        }

        if ($response->isRedirection()) {
            return false;
        }

        if (! $response->isHtml()) {
            return false;
        }

        if ($response->isAttachment()) {
            return false;
        }

        return ! $response->isJson();
    }
}
