<?php

declare(strict_types=1);

namespace Flasher\Laravel\Http;

use Flasher\Prime\Http\ResponseInterface;
use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final readonly class Response implements ResponseInterface
{
    public function __construct(private SymfonyResponse $response)
    {
    }

    public function isRedirection(): bool
    {
        return $this->response->isRedirection();
    }

    public function isJson(): bool
    {
        return $this->response instanceof SymfonyJsonResponse;
    }

    public function isHtml(): bool
    {
        $contentType = $this->response->headers->get('Content-Type');

        if (!\is_string($contentType)) {
            return false;
        }

        return false !== stripos($contentType, 'html');
    }

    public function isAttachment(): bool
    {
        $contentDisposition = $this->response->headers->get('Content-Disposition', '');

        if (!$contentDisposition) {
            return false;
        }

        return false !== stripos($contentDisposition, 'attachment;');
    }

    public function isSuccessful(): bool
    {
        return $this->response->isSuccessful();
    }

    public function getContent(): string
    {
        return $this->response->getContent() ?: '';
    }

    public function setContent(string $content): void
    {
        $original = null;
        if ($this->response instanceof LaravelResponse && $this->response->getOriginalContent()) {
            $original = $this->response->getOriginalContent();
        }

        $this->response->setContent($content);

        // Restore original response (eg. the View or Ajax data)
        if ($original && $this->response instanceof LaravelResponse) {
            $this->response->original = $original;
        }
    }

    public function hasHeader(string $key): bool
    {
        return $this->response->headers->has($key);
    }

    public function getHeader(string $key): ?string
    {
        return $this->response->headers->get($key);
    }

    public function setHeader(string $key, array|string|null $values): void
    {
        $this->response->headers->set($key, $values);
    }

    public function removeHeader(string $key): void
    {
        $this->response->headers->remove($key);
    }
}
