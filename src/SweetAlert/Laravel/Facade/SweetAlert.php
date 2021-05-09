<?php

namespace Flasher\SweetAlert\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class SweetAlert extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher.sweet_alert';
    }
}
