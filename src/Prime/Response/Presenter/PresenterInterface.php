<?php

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

interface PresenterInterface
{
    /**
     * @return mixed
     */
    public function render(Response $response);
}
