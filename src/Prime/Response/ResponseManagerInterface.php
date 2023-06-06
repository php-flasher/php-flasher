<?php

namespace Flasher\Prime\Response;

use Flasher\Prime\Response\Presenter\PresenterInterface;

interface ResponseManagerInterface
{
    /**
     * @param mixed[] $criteria
     * @param string  $presenter
     * @param mixed[] $context
     */
    public function render(array $criteria = [], $presenter = 'html', array $context = []);

    /**
     * @param string                      $alias
     * @param callable|PresenterInterface $presenter
     *
     * @return void
     */
    public function addPresenter($alias, $presenter);
}
