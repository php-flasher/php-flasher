<?php

namespace Flasher\Toastr\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

class Toastr extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'flasher.toastr';
    }
}