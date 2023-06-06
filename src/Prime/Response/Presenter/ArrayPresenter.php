<?php

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class ArrayPresenter implements PresenterInterface
{
    public function render(Response $response)
    {
        return $response->toArray();
    }
}
