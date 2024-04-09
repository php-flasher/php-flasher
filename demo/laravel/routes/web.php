<?php

use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    session()->flash('success', 'Hello from default Symfony');

    return <<<HTML
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>flash</title>
            </head>
            <body>
                <ul>
                    <li><a href="/">/</a></li>
                    <li><a href="/adapter/flasher">/adapter/flasher</a></li>
                    <li><a href="/adapter/noty">/adapter/noty</a></li>
                    <li><a href="/adapter/notyf">/adapter/notyf</a></li>
                    <li><a href="/adapter/sweetalert">/adapter/sweetalert</a></li>
                    <li><a href="/adapter/toastr">/adapter/toastr</a></li>
                </ul>
            </body>
        </html>
    HTML;
})->name('app_home');

Route::get('/adapter/{adapter}', function (FlasherInterface $flasher, string $adapter) {
    $factory = $flasher->create($adapter);

    $factory->success('Operation completed successfully.');
    $factory->info('Please note that some information has been updated.');
    $factory->warning('This action could have potential consequences.');
    $factory->error('An error occurred while processing your request.');

    return view('welcome');
})->name('app_adapter');

Route::get('/livewire/counter', \App\Livewire\Counter::class);
Route::get('/livewire/eventous', \App\Livewire\Eventous::class);
