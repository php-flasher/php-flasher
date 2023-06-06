<?php

namespace Flasher\Prime\Translation;

interface ResourceInterface
{
    /**
     * @return string
     */
    public function getResourceType();

    /**
     * @return string
     */
    public function getResourceName();
}
