<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandler;
use Flasher\Prime\Response\Presenter\HtmlPresenter;

final class ResponseExtension
{
    public function __construct(
        private readonly FlasherInterface $flasher,
        private readonly ContentSecurityPolicyHandler $cspHandler,
    ) {
    }

    public function render(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!$this->isRenderable($request, $response)) {
            return $response;
        }

        $content = $response->getContent();

        $placeHolders = [
            HtmlPresenter::FLASHER_REPLACE_ME,
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

        $alreadyRendered = HtmlPresenter::FLASHER_REPLACE_ME === $insertPlaceHolder;
        $nonces = $this->cspHandler->updateResponseHeaders($request, $response);

        $context = [
            'envelopes_only' => $alreadyRendered,
            'csp_script_nonce' => $nonces['csp_script_nonce'] ?? null,
            'csp_style_nonce' => $nonces['csp_style_nonce'] ?? null,
        ];

        $htmlResponse = $this->flasher->render('html', [], $context);

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
        return !$request->isXmlHttpRequest()
            && $request->isHtmlRequestFormat()
            && $response->isHtml()
            && !$response->isRedirection()
            && !$response->isAttachment()
            && !$response->isJson();
    }
}
