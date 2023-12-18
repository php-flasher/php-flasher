<?php

declare(strict_types=1);

namespace Flasher\Prime\Phpstan\ReturnTypes;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final class FlashHelperExtension implements DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return 'flash' === $functionReflection->getName();
    }

    public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): Type
    {
        if (count($functionCall->getArgs())) {
            return new ObjectType(Envelope::class);
        }

        return TypeCombinator::union(new ObjectType(FlasherInterface::class), new ObjectType(NotificationFactoryInterface::class));
    }
}
