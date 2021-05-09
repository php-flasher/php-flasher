<?php

namespace Flasher\Notyf\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Notyf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher.notyf';
    }
}
