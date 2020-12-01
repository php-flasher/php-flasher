<?php

namespace PHPSTORM_META;

use Flasher\Prime\Envelope;
use Flasher\Prime\Flasher;
use Flasher\Prime\Presenter\PresenterManager;
use Flasher\Prime\Renderer\RendererManager;

override(Envelope::get(), type(0));

override(Flasher::make(''), map(['' => '@']));
override(RendererManager::make(''), map(['' => '@']));
override(PresenterManager::make(''), map(['' => '@']));
