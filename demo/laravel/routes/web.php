<?php

declare(strict_types=1);

use App\Entity\Book;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    sweetalert()->timerProgressBar()->success('Your account has been successfully created!');
    noty()->layout('topCenter')->success('Welcome back, John Doe!');
    notyf()->ripple(false)->warning('Your subscription is about to expire in 3 days.');
    toastr()->positionClass('toast-bottom-left')->error('Payment failed. Please try again.');
    flash()->use('flasher')->success('Your profile has been updated successfully.');
    flash()->created(new Book('The Great Gatsby'));
    flash()->saved(new Book('1984'));
    session()->flash('success', 'Your settings have been saved.');
    return view('welcome');
})->name('app_home');

Route::get('/redirect', function () {
    session()->flash('success', 'You have been redirected successfully.');
    return redirect('/destination');
});

Route::get('/destination', function () {
    return view('welcome');
});
