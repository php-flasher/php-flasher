<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Http;

use Flasher\Prime\Http\RequestInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class Request implements RequestInterface
{
    /**
     * @var SymfonyRequest
     */
    private $request;

    public function __construct(SymfonyRequest $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function isXmlHttpRequest()
    {
        return $this->request->isXmlHttpRequest();
    }

    /**
     * {@inheritDoc}
     */
    public function hasSession()
    {
        return $this->request->hasSession();
    }

    /**
     * {@inheritDoc}
     */
    public function hasType($type)
    {
        /** @var FlashBagInterface $flashBag */
        $flashBag = $this->request->getSession()->getFlashBag();

        return $flashBag->has($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType($type)
    {
        /** @var FlashBagInterface $flashBag */
        $flashBag = $this->request->getSession()->getFlashBag();

        return $flashBag->get($type);
    }

    /**
     * {@inheritDoc}
     */
    public function forgetType($type)
    {
        $this->getType($type);
    }
}
