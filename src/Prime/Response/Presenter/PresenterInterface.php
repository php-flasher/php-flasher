<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

interface PresenterInterface
{
    /**
     * @return mixed
     */
    public function render(Response $response);
}
