<?php

namespace Flasher\Symfony\Http;

use Flasher\Prime\Http\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final class Response implements ResponseInterface
{
    /**
     * @var SymfonyResponse
     */
    private $response;

    public function __construct(SymfonyResponse $response)
    {
        $this->response = $response;
    }

    public function isRedirection()
    {
        return $this->response->isRedirection();
    }

    public function isJson()
    {
        return $this->response instanceof JsonResponse;
    }

    public function isHtml()
    {
        $contentType = $this->response->headers->get('Content-Type');

        if (!\is_string($contentType)) {
            return false;
        }

        return false !== stripos($contentType, 'html');
    }

    public function isAttachment()
    {
        $contentDisposition = $this->response->headers->get('Content-Disposition', '');

        if (!\is_string($contentDisposition)) {
            return false;
        }

        return false !== stripos($contentDisposition, 'attachment;');
    }

    public function getContent()
    {
        $content = $this->response->getContent();

        return \is_string($content) ? $content : '';
    }

    public function setContent($content)
    {
        $this->response->setContent($content);
    }
}
