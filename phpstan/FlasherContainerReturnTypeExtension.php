<?php

declare(strict_types=1);

namespace Flasher\Phpstan;

use Flasher\Noty\Prime\NotyFactory;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactory;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Flasher\Toastr\Prime\ToastrFactory;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

final class FlasherContainerReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return FlasherContainer::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return 'create' === $methodReflection->getName();
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        if ([] === $methodCall->args) {
            return new NullType();
        }

        $argType = $scope->getType($methodCall->args[0]->value);

        return $argType instanceof ConstantStringType
            ? match ($argType->getValue()) {
                'flasher' => new ObjectType(NotificationFactory::class),
                'flasher.noty_factory' => new ObjectType(NotyFactory::class),
                'flasher.toastr_factory' => new ObjectType(ToastrFactory::class),
                'flasher.sweetalert_factory' => new ObjectType(SweetAlertFactory::class),
                default => new MixedType(),
            }
            : new MixedType();
    }
}
