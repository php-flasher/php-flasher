<?php

namespace PHPSTORM_META;

override(\Illuminate\Foundation\Application::make(0), map([
    'config' => \Illuminate\Contracts\Config\Repository::class,
    'session' => \Illuminate\Session\SessionManager::class,
    'view' => \Illuminate\View\Factory::class,
    'translator' => \Illuminate\Translation\Translator::class,
    'livewire' => \Livewire\LivewireManager::class,
]));

expectedArguments(\Illuminate\Contracts\Config\Repository::get(), 0, 'flasher');
