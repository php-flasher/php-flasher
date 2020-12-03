<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Manager\AbstractManager;

/**
 * @method \Flasher\Prime\Filter\FilterInterface make($driver = null)
 */
final class FilterManager extends AbstractManager
{
    protected function getDefaultDriver()
    {
        return $this->config->get('default_filter', 'default');
    }
}
