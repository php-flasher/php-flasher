<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;

final class RequestExtension
{
    /**
     * @var array<string, string>
     */
    private readonly array $mapping;

    /**
     * @param  array<string, string[]>  $mapping
     */
    public function __construct(private readonly FlasherInterface $flasher, array $mapping = [])
    {
        $this->mapping = $this->flatMapping($mapping);
    }

    /**
     * @return ResponseInterface
     */
    public function flash(RequestInterface $request, ResponseInterface $response)
    {
        if (! $request->hasSession()) {
            return $response;
        }

        foreach ($this->mapping as $alias => $type) {
            if (! $request->hasType($alias)) {
                continue;
            }

            $messages = (array) $request->getType($alias);

            foreach ($messages as $message) {
                $this->flasher->addFlash($type, $message);
            }

            $request->forgetType($alias);
        }

        return $response;
    }

    /**
     * @param  array<string, string[]>  $mapping
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
}
