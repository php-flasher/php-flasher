<?php

declare(strict_types=1);

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

// Main pages
Route::get('/', [DemoController::class, 'home'])->name('home');
Route::get('/types', [DemoController::class, 'types'])->name('types');
Route::get('/themes', [DemoController::class, 'themes'])->name('themes');
Route::get('/adapters', [DemoController::class, 'adapters'])->name('adapters');
Route::get('/positions', [DemoController::class, 'positions'])->name('positions');
Route::get('/examples', [DemoController::class, 'examples'])->name('examples');
Route::get('/playground', [DemoController::class, 'playground'])->name('playground');
Route::get('/livewire', [DemoController::class, 'livewire'])->name('livewire');

// AJAX endpoints
Route::post('/notify', [DemoController::class, 'notify'])->name('notify');
Route::post('/example/{scenario}', [DemoController::class, 'runExample'])->name('example.run');
