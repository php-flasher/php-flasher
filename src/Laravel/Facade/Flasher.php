<?php

namespace Flasher\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Flasher extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'flasher';
    }
}