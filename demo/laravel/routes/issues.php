<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/issues/190', function () {
    flash()->success('Your order has been placed successfully.');
    // Passing another success message with the view
    return redirect('/issues/190/redirect')->with('success', 'Your order will be delivered in 3-5 business days.');
});

Route::get('/issues/190/redirect', function () {
    return view('welcome');
});
