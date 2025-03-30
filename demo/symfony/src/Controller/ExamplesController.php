<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExamplesController extends AbstractController
{
    #[Route('/examples', name: 'app_examples')]
    public function index(): Response
    {
        flash()->info('Browse through our examples to see PHPFlasher in action!');

        return $this->render('examples/index.html.twig');
    }

    #[Route('/examples/form', name: 'app_form_example')]
    public function formExample(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');

            // Simulate validation
            $errors = [];

            if (empty($name)) {
                $errors['name'] = 'Name is required';
            }

            if (empty($email)) {
                $errors['email'] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format';
            }

            // Display appropriate notifications
            if (empty($errors)) {
                flash()->success('Form submitted successfully! Thank you, ' . $name);
            } else {
                foreach ($errors as $field => $message) {
                    flash()->error($message);
                }
            }
        }

        return $this->render('examples/form.html.twig');
    }

    #[Route('/examples/ajax', name: 'app_ajax_example')]
    public function ajaxExample(): Response
    {
        return $this->render('examples/ajax.html.twig');
    }

    #[Route('/examples/ajax/process', name: 'app_ajax_process', methods: ['POST'])]
    public function ajaxProcess(Request $request): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'AJAX requests only'], 400);
        }

        $action = $request->request->get('action');
        $success = mt_rand(0, 10) > 2; // 80% success rate for demo

        if ($success) {
            switch ($action) {
                case 'save':
                    flash()->success('Data saved successfully!');
                    break;
                case 'update':
                    flash()->success('Record updated successfully!');
                    break;
                case 'delete':
                    flash()->info('Item has been deleted.');
                    break;
                default:
                    flash()->success('Operation completed successfully!');
            }

            return new JsonResponse(['success' => true]);
        } else {
            // Simulate errors
            flash()->error('An error occurred while processing your request. Please try again.');
            return new JsonResponse(['success' => false], 500);
        }
    }

    #[Route('/examples/real-world', name: 'app_real_world')]
    public function realWorldExamples(): Response
    {
        return $this->render('examples/real-world.html.twig');
    }

    #[Route('/examples/real-world/user-registration', name: 'app_example_user_registration')]
    public function userRegistration(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            // Simulate user registration
            $username = $request->request->get('username');

            if (!empty($username)) {
                flash()->option('timeout', 5000)
                       ->option('showProgressbar', true)
                       ->success('Registration successful! Welcome, ' . $username . '!');

                // Send additional notification about email verification
                flash()->option('timeout', 8000)
                       ->info('A verification email has been sent to your inbox.');
            } else {
                flash()->error('Username is required.');
            }
        }

        return $this->render('examples/user-registration.html.twig');
    }

    #[Route('/examples/real-world/shopping-cart', name: 'app_example_shopping_cart')]
    public function shoppingCart(): Response
    {
        return $this->render('examples/shopping-cart.html.twig');
    }

    #[Route('/examples/real-world/add-to-cart', name: 'app_add_to_cart', methods: ['POST'])]
    public function addToCart(Request $request): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'AJAX requests only'], 400);
        }

        $productId = $request->request->get('product_id');
        $productName = $request->request->get('product_name', 'Product');

        // Simulate adding to cart
        flash()->option('position', 'bottom-right')
               ->option('showCloseButton', true)
               ->success($productName . ' added to your cart!');

        return new JsonResponse(['success' => true]);
    }
}
