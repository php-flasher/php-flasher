<?php

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class ArrayPresenter implements PresenterInterface
{
    /**
     * @inheritDoc
     */
    public function render(Response $response)
    {
        return array();
    }
}
