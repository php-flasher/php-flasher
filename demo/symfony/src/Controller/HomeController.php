<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Welcome notification
        flash()->option('timeout', 10000)
               ->info('Welcome to the PHPFlasher Demo! 👋 Explore different features using the navigation.');

        return $this->render('home/index.html.twig');
    }

    #[Route('/installation', name: 'app_installation')]
    public function installation(): Response
    {
        return $this->render('home/installation.html.twig');
    }

    #[Route('/basic-usage', name: 'app_basic_usage')]
    public function basicUsage(): Response
    {
        // Basic success notification
        flash()->success('This is a success notification!');

        return $this->render('home/basic-usage.html.twig');
    }

    #[Route('/playground', name: 'app_playground')]
    public function playground(): Response
    {
        return $this->render('home/playground.html.twig');
    }

    #[Route('/theme-builder', name: 'app_theme_builder')]
    public function themeBuilder(): Response
    {
        return $this->render('home/theme-builder.html.twig');
    }

    #[Route('/show-notification', name: 'app_show_notification', methods: ['POST'])]
    public function showNotification(Request $request): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'AJAX requests only'], 400);
        }

        $data = json_decode($request->getContent(), true);
        $type = $data['type'] ?? 'info';
        $message = $data['message'] ?? 'This is a notification!';

        // Create notification based on type
        switch ($type) {
            case 'success':
                flash()->success($message);
                break;
            case 'error':
                flash()->error($message);
                break;
            case 'warning':
                flash()->warning($message);
                break;
            case 'info':
            default:
                flash()->info($message);
                break;
        }

        return new JsonResponse(['status' => 'success']);
    }
}
