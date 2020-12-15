<?php

namespace Flasher\Prime\Renderer\Presenter;

final class ArrayPresenter extends AbstractPresenter
{
    /**
     * @inheritDoc
     */
    public function render(array $envelopes, array $context = array())
    {
        return $this->toArray($envelopes);
    }
}
