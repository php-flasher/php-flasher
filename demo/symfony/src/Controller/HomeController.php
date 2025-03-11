<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $themes = [
            // 'flasher',
            // 'amber',
            // 'sapphire',
            // 'crystal',

            // 'emerald',
            // 'ruby',
            // 'onyx',

            // 'jade',
            // 'aurora',
            // 'neon',
            // 'minimal',

            // 'material',
            // 'google',

            // 'ios',
            // 'slack',
            // 'facebook',
            'amazon',
        ];

        $positions = [
            // 'top-left',
            'top-right',
            // 'bottom-left',
            // 'bottom-right',
            // 'top-center',
            // 'bottom-center',
            // 'center-left',
            // 'center-right',
            // 'center-center',
        ];

        $messages = [
            'info' => 'Welcome back!',
            'warning' => 'Are you sure you want to proceed?',
            'error' => 'Oops! Something went wrong!',
            'success' => 'Data has been saved successfully!',
        ];

        foreach ($themes as $index => $theme) {
            foreach ($messages as $type => $message) {
                $position = $positions[$index % \count($positions)];

                // $message = \sprintf('%s: %s', $theme, $message);

                flash()
                    ->use("theme.$theme")
                    ->option('position', $position)
                    ->$type($message);
            }
        }

        $plugins = [
            // 'noty',
            // 'notyf',
            // 'sweetalert',
            // 'toastr',
        ];

        foreach ($plugins as $plugin) {
            foreach ($messages as $type => $message) {
                flash()
                    ->use($plugin)
                    ->$type($message);
            }
        }

        return $this->render('home/index.html.twig');
    }
}
