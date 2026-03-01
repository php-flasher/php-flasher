<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DemoController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/types', name: 'app_types')]
    public function types(): Response
    {
        return $this->render('types.html.twig');
    }

    #[Route('/themes', name: 'app_themes')]
    public function themes(): Response
    {
        return $this->render('themes.html.twig');
    }

    #[Route('/adapters', name: 'app_adapters')]
    public function adapters(): Response
    {
        return $this->render('adapters.html.twig');
    }

    #[Route('/positions', name: 'app_positions')]
    public function positions(): Response
    {
        return $this->render('positions.html.twig');
    }

    #[Route('/examples', name: 'app_examples')]
    public function examples(): Response
    {
        return $this->render('examples.html.twig');
    }

    #[Route('/playground', name: 'app_playground')]
    public function playground(): Response
    {
        return $this->render('playground.html.twig');
    }

    #[Route('/notify', name: 'app_notify', methods: ['POST'])]
    public function notify(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $type = $data['type'] ?? 'success';
        $message = $data['message'] ?? 'Notification message';
        $title = $data['title'] ?? null;
        $theme = $data['theme'] ?? null;
        $position = $data['position'] ?? 'top-right';
        $timeout = (int) ($data['timeout'] ?? 5000);

        $flasher = flash();

        // Apply theme if specified
        if ($theme && 'flasher' !== $theme) {
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

        return new JsonResponse(['success' => true]);
    }

    #[Route('/example/{scenario}', name: 'app_example', methods: ['POST'])]
    public function runExample(string $scenario): JsonResponse
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

        return new JsonResponse(['success' => true]);
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
