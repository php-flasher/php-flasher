<?php

namespace Flasher\Pnotify\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Pnotify extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'flasher.pnotify';
    }
}