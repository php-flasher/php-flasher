<?php

namespace Flasher\Prime\Renderer\Presenter;

interface PresenterManagerInterface
{
    /**
     * @param string             $alias
     * @param PresenterInterface $response
     */
    public function addPresenter($alias, PresenterInterface $response);

    /**
     * @param string $alias
     *
     * @return PresenterInterface
     */
    public function create($alias);
}
