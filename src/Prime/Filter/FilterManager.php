<?php

namespace Flasher\Prime\TestsFilter;

use Flasher\Prime\TestsManager\AbstractManager;

/**
 * @method \Flasher\Prime\TestsFilter\FilterInterface make($driver = null)
 */
final class FilterManager extends AbstractManager
{
    protected function getDefaultDriver()
    {
        return $this->config->get('default_filter', 'default');
    }
}
