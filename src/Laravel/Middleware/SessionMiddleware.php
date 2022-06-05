<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Middleware;

use Closure;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class SessionMiddleware
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
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if ($request->isXmlHttpRequest() || !$request->hasSession()) {
            return $response;
        }

        foreach ($this->mapping as $alias => $type) {
            if (false === $request->session()->has($alias)) {
                continue;
            }

            /** @var string $message */
            $message = $request->session()->get($alias);
            $this->flasher->addFlash($type, $message);

            $request->session()->forget($alias);
        }

        return $response;
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
}
