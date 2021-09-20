<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Storage\ArrayStorage;
use Flasher\Prime\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class StorageFactory
{
    private $requestStack;

    public function __construct($requestStack = null)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return StorageInterface
     */
    public function __invoke()
    {
        if ($this->requestStack instanceof SessionInterface) {
            return new Storage($this->requestStack);
        }

        if (!$this->requestStack instanceof RequestStack) {
            return new ArrayStorage();
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request instanceof Request && $request->hasSession()) {
            return new Storage($request->getSession());
        }

        return new ArrayStorage();
    }
}
