<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\FlasherInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class SessionListener
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    /**
     * @var array<string, string>
     */
    private $mapping;

    /**
     * @param array<string, string[]> $mapping
     */
    public function __construct(FlasherInterface $flasher, array $mapping = array())
    {
        $this->flasher = $flasher;
        $this->mapping = $this->flatMapping($mapping);
    }

    /**
     * @param ResponseEvent $event
     *
     * @return void
     */
    public function onKernelResponse($event)
    {
        $request = $event->getRequest();

        if (!$this->isMainRequest($event) || $request->isXmlHttpRequest() || !$request->hasSession()) {
            return;
        }

        /** @var FlashBagInterface $flashBag */
        $flashBag = $request->getSession()->getFlashBag();
        foreach ($this->mapping as $alias => $type) {
            if (false === $flashBag->has($alias)) {
                continue;
            }

            /** @var string[] $messages */
            $messages = $flashBag->get($alias);

            foreach ($messages as $message) {
                $this->flasher->addFlash($type, $message);
            }
        }
    }

    /**
     * @param array<string, string[]> $mapping
     *
     * @return array<string, string>
     */
    private function flatMapping(array $mapping)
    {
        $flatMapping = array();

        foreach ($mapping as $type => $aliases) {
            foreach ($aliases as $alias) {
                $flatMapping[$alias] = $type;
            }
        }

        return $flatMapping;
    }

    /**
     * @param ResponseEvent $event
     *
     * @return bool
     */
    private function isMainRequest($event)
    {
        if (method_exists($event, 'isMainRequest')) {
            return $event->isMainRequest();
        }

        if (method_exists($event, 'isMasterRequest')) { // @phpstan-ignore-line
            return $event->isMasterRequest();
        }

        return 1 === $event->getRequestType();
    }
}
