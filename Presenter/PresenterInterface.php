<?php

namespace Flasher\Prime\TestsPresenter;

interface PresenterInterface
{
    /**
     * @param string|null $name
     * @param array       $context
     *
     * @return bool
     */
    public function supports($name = null, array $context = array());

    /**
     * @param string $criteria
     *
     * @return string
     */
    public function render($criteria = 'default');
}
