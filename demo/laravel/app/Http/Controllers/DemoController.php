<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DemoController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function types(): View
    {
        return view('types');
    }

    public function themes(): View
    {
        return view('themes');
    }

    public function adapters(): View
    {
        return view('adapters');
    }

    public function positions(): View
    {
        return view('positions');
    }

    public function examples(): View
    {
        return view('examples');
    }

    public function playground(): View
    {
        return view('playground');
    }

    public function livewire(): View
    {
        return view('livewire');
    }

    public function notify(Request $request): JsonResponse
    {
        $type = $request->input('type', 'success');
        $message = $request->input('message', 'Notification message');
        $title = $request->input('title');
        $theme = $request->input('theme');
        $position = $request->input('position', 'top-right');
        $timeout = (int) $request->input('timeout', 5000);

        $flasher = flash();

        // Apply theme if specified
        if ($theme && $theme !== 'flasher') {
            $flasher = $flasher->use("theme.{$theme}");
        }

        $options = [
            'position' => $position,
            'timeout' => $timeout,
        ];

        if ($title) {
            $options['title'] = $title;
        }

        $flasher->{$type}($message, $options);

        return response()->json(['success' => true]);
    }

    public function runExample(Request $request, string $scenario): JsonResponse
    {
        match ($scenario) {
            'registration' => $this->registrationExample(),
            'login_failed' => $this->loginFailedExample(),
            'validation' => $this->validationExample(),
            'shopping_cart' => $this->shoppingCartExample(),
            'file_upload' => $this->fileUploadExample(),
            'settings' => $this->settingsExample(),
            'payment_success' => $this->paymentSuccessExample(),
            'payment_failed' => $this->paymentFailedExample(),
            'delete_confirm' => $this->deleteConfirmExample(),
            'session_expiring' => $this->sessionExpiringExample(),
            default => flash()->info('Example not found'),
        };

        return response()->json(['success' => true]);
    }

    private function registrationExample(): void
    {
        flash()->success('Welcome! Your account has been created.');
        flash()->info('Please check your email to verify your account.');
    }

    private function loginFailedExample(): void
    {
        flash()->error('Invalid email or password.');
        flash()->info('Forgot your password? Click here to reset.');
    }

    private function validationExample(): void
    {
        flash()->error('The email field is required.');
        flash()->error('Password must be at least 8 characters.');
        flash()->error('Please accept the terms and conditions.');
    }

    private function shoppingCartExample(): void
    {
        flash()->success('iPhone 15 Pro added to cart!');
        flash()->warning('Only 2 items left in stock!');
        flash()->info('Add $20 more for free shipping!');
    }

    private function fileUploadExample(): void
    {
        flash()->success('document.pdf uploaded successfully!');
        flash()->info('File size: 2.4 MB');
    }

    private function settingsExample(): void
    {
        flash()->success('Settings saved successfully!');
        flash()->info('Some changes may require a page refresh.');
    }

    private function paymentSuccessExample(): void
    {
        flash()->success('Payment of $149.99 confirmed!');
        flash()->info('Order #12345 - Receipt sent to your email.');
    }

    private function paymentFailedExample(): void
    {
        flash()->error('Payment declined by your bank.');
        flash()->warning('Please try a different payment method.');
        flash()->info('Your cart has been saved.');
    }

    private function deleteConfirmExample(): void
    {
        flash()->warning('Are you sure? This action cannot be undone.');
        flash()->info('Click confirm to delete or cancel to keep the item.');
    }

    private function sessionExpiringExample(): void
    {
        flash()->warning('Your session will expire in 5 minutes.');
        flash()->info('Click anywhere to stay logged in.');
    }
}
