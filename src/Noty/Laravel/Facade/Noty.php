<?php

namespace Flasher\Noty\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Noty extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'flasher.noty';
    }
}