<?php

namespace Flasher\Prime\Presenter;

interface PresenterInterface
{
    /**
     * @param string $criteria
     *
     * @return string
     */
    public function render($criteria = 'default');
}
