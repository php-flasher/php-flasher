<?php

namespace PHPSTORM_META;

registerArgumentsSet('types', 'success', 'error', 'warning', 'info');

expectedArguments(\Symfony\Bundle\FrameworkBundle\Controller\AbstractController::addFlash(), 0, argumentsSet('types'));
expectedArguments(\Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface::add(), 0, argumentsSet('types'));
