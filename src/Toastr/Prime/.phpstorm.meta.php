<?php

namespace PHPSTORM_META;

use Flasher\Toastr\Prime\ToastrBuilder;

expectedArguments(ToastrBuilder::showMethod(), 1, ['fadeIn', 'slideDown', 'show']);
expectedArguments(ToastrBuilder::showEasing(), 1, ['swing', 'linear']);
expectedArguments(ToastrBuilder::positionClass(), 1, ['toast-top-right', 'toast-top-center', 'toast-bottom-center', 'toast-top-full-width', 'toast-bottom-full-width', 'toast-top-left', 'toast-bottom-right', 'toast-bottom-left']);
