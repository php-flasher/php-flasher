<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class ArrayPresenter implements PresenterInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(Response $response)
    {
        return $response->toArray();
    }
}
