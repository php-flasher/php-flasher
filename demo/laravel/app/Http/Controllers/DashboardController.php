<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with overview of PHPFlasher features
     */
    public function index()
    {
        flash()->option('timeout', 10000)
               ->info('Welcome to the PHPFlasher Laravel Demo! 👋 Explore different examples using the navigation.');

        return view('dashboard');
    }

    /**
     * Show all notification types at once
     */
    public function showAllTypes()
    {
        flash()->success('This is a success notification!');
        flash()->info('This is an information notification!');
        flash()->warning('This is a warning notification!');
        flash()->error('This is an error notification!');

        return redirect()->back();
    }

    /**
     * Show theme selector
     */
    public function themeSelector()
    {
        return view('features.themes');
    }

    /**
     * Display a notification with the selected theme
     */
    public function showTheme(Request $request)
    {
        $theme = $request->input('theme', 'default');

        flash()
            ->use("theme.$theme")
            ->success("This notification uses the '$theme' theme!");

        return redirect()->route('themes');
    }
}
