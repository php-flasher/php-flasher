<?php

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

interface PresenterInterface
{
    public function render(Response $response);
}
