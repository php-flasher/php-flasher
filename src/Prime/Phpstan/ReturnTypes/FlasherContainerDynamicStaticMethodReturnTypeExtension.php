<?php

declare(strict_types=1);

namespace Flasher\Prime\Phpstan\ReturnTypes;

use Flasher\Noty\Prime\NotyFactory;
use Flasher\Notyf\Prime\NotyfFactory;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactory;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Flasher\Toastr\Prime\Toastr;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

final class FlasherContainerDynamicStaticMethodReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return FlasherContainer::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return 'create' === $methodReflection->getName();
    }

    public function getTypeFromStaticMethodCall(MethodReflection $methodReflection, StaticCall $methodCall, Scope $scope): Type
    {
        $args = $methodCall->getArgs();
        $type = $scope->getType($args[0]->value);

        foreach ($type->getConstantStrings() as $service) {
            return match ($service->getValue()) {
                'flasher' => new ObjectType(NotificationFactory::class),
                'flasher.noty_factory' => new ObjectType(NotyFactory::class),
                'flasher.notyf_factory' => new ObjectType(NotyfFactory::class),
                'flasher.toastr_factory' => new ObjectType(Toastr::class),
                'flasher.sweetalert_factory' => new ObjectType(SweetAlertFactory::class),
                default => new MixedType(),
            };
        }

        return new MixedType();
    }
}
