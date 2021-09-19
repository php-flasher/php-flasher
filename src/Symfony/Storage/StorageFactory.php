<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Storage\ArrayStorage;
use Flasher\Prime\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class StorageFactory
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return StorageInterface
     */
    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request instanceof Request || false === $request->hasSession()) {
            return new ArrayStorage();
        }

        return new Storage($request->getSession());
    }
}
