<?php

namespace Flasher\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Flasher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher';
    }
}
