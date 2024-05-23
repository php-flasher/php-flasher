<?php

use App\Entity\Book;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // sweetalert()->timerProgressBar()->success('hello from Home Controller');
    // noty()->layout('topCenter')->success('hello from Home Controller');
    // notyf()->ripple(false)->warning('hello from Home Controller');
    // toastr()->positionClass('toast-bottom-left')->error('hello from Home Controller');
    // flash()->use('flasher')->success('hello from flasher factory');

    // flash()->created(new Book('lord of the rings'));
    // flash()->saved(new Book('harry potter'));

    session()->flash('success', 'this from laravel session flash');

    return view('welcome');
})->name('app_home');
