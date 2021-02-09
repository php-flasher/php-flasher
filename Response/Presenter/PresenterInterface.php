<?php

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

interface PresenterInterface
{
    /**
     * @param Response $response
     *
     * @return mixed
     */
    public function render(Response $response);
}
