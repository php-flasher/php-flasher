<?php

namespace Flasher\Prime\EventDispatcher\Event;

final class ResponseEvent
{
    private $response;

    /**
     * @var string
     */
    private $presenter;

    /**
     * @param string $presenter
     */
    public function __construct($response, $presenter)
    {
        $this->response = $response;
        $this->presenter = $presenter;
    }

    public function getResponse()
    {
        return $this->response;
    }

    /**
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
