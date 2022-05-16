<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\Event;

final class ResponseEvent
{
    /**
     * @var mixed
     */
    private $response;

    /**
     * @var string
     */
    private $presenter;

    /**
     * @param mixed  $response
     * @param string $presenter
     */
    public function __construct($response, $presenter)
    {
        $this->response = $response;
        $this->presenter = $presenter;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     *
     * @return void
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getPresenter()
    {
        return $this->presenter;
    }
}
