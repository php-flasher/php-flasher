<?php

namespace Flasher\Prime\Renderer\Presenter;

use Flasher\Prime\Envelope;

interface PresenterInterface
{
    /**
     * @param Envelope[] $envelopes
     * @param array $context
     *
     * @return mixed
     */
    public function render(array $envelopes, array $context = array());
}
