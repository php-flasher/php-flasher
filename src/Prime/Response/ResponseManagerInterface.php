<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response;

use Flasher\Prime\Response\Presenter\PresenterInterface;

interface ResponseManagerInterface
{
    /**
     * @param mixed[] $criteria
     * @param string  $presenter
     * @param mixed[] $context
     *
     * @return mixed
     */
    public function render(array $criteria = array(), $presenter = 'html', array $context = array());

    /**
     * @param string                      $alias
     * @param callable|PresenterInterface $presenter
     *
     * @return void
     */
    public function addPresenter($alias, $presenter);
}
