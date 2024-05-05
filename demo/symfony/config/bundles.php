<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Flasher\Symfony\FlasherSymfonyBundle::class => ['all' => true],
    Flasher\Noty\Symfony\FlasherNotySymfonyBundle::class => ['all' => true],
    Flasher\Notyf\Symfony\FlasherNotyfSymfonyBundle::class => ['all' => true],
    Flasher\Toastr\Symfony\FlasherToastrSymfonyBundle::class => ['all' => true],
    Flasher\SweetAlert\Symfony\FlasherSweetAlertSymfonyBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Nelmio\SecurityBundle\NelmioSecurityBundle::class => ['all' => true],
];
