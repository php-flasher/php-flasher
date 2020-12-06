<?php

namespace PHPSTORM_META;

use Flasher\Noty\Prime\NotyBuilder;

expectedArguments(NotyBuilder::showMethod(), 1, ['fadeIn', 'slideDown', 'show']);
expectedArguments(NotyBuilder::showEasing(), 1, ['swing', 'linear']);
expectedArguments(NotyBuilder::positionClass(), 1, ['toast-top-right', 'toast-top-center', 'toast-bottom-center', 'toast-top-full-width', 'toast-bottom-full-width', 'toast-top-left', 'toast-bottom-right', 'toast-bottom-left']);
