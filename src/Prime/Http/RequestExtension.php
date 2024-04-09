<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;

final readonly class RequestExtension implements RequestExtensionInterface
{
    /**
     * @var array<string, string>
     */
    private array $mapping;

    /**
     * @param array<string, string[]> $mapping
     */
    public function __construct(private FlasherInterface $flasher, array $mapping = [])
    {
        $this->mapping = $this->flatMapping($mapping);
    }

    public function flash(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!$request->hasSession()) {
            return $response;
        }

        $this->processRequest($request);

        return $response;
    }

    /**
     * @param array<string, string[]> $mapping
     *
     * @return array<string, string>
     */
    private function flatMapping(array $mapping): array
    {
        $flatMapping = [];

        foreach ($mapping as $type => $aliases) {
            foreach ($aliases as $alias) {
                $flatMapping[$alias] = $type;
            }
        }

        return $flatMapping;
    }

    /**
     * Process the request and flash messages.
     */
    private function processRequest(RequestInterface $request): void
    {
        foreach ($this->mapping as $alias => $type) {
            if (!$request->hasType($alias)) {
                continue;
            }

            $messages = (array) $request->getType($alias);

            foreach ($messages as $message) {
                $this->flasher->flash($type, $message);
            }

            $request->forgetType($alias);
        }
    }
}
