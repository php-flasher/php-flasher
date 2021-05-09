<?php

namespace Flasher\Noty\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Noty extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher.noty';
    }
}
