<?php

declare(strict_types=1);

namespace Flasher\Prime\Phpstan\ReturnTypes;

use Flasher\Noty\Prime\NotyInterface;
use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\FlasherInterface;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use Flasher\Toastr\Prime\ToastrInterface;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

final class FlasherContainerDynamicStaticMethodReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    private const MAPPING = [
        'flasher' => FlasherInterface::class,
        'flasher.noty' => NotyInterface::class,
        'flasher.notyf' => NotyfInterface::class,
        'flasher.sweetalert' => SweetAlertInterface::class,
        'flasher.toastr' => ToastrInterface::class,
    ];

    public function getClass(): string
    {
        return FlasherContainer::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return 'create' === $methodReflection->getName();
    }

    public function getTypeFromStaticMethodCall(MethodReflection $methodReflection, StaticCall $methodCall, Scope $scope): ?Type
    {
        $args = $methodCall->getArgs();
        $type = $scope->getType($args[0]->value);

        foreach ($type->getConstantStrings() as $service) {
            $factory = $service->getValue();

            return isset(self::MAPPING[$factory]) ? new ObjectType(self::MAPPING[$factory]) : null;
        }

        return null;
    }
}
