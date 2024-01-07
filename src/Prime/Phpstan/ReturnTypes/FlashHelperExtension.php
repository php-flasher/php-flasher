<?php

declare(strict_types=1);

namespace Flasher\Prime\Phpstan\ReturnTypes;

use Flasher\Noty\Prime\NotyInterface;
use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use Flasher\Toastr\Prime\ToastrInterface;
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
        return \in_array($functionReflection->getName(), [
            'flash',
            'noty',
            'notyf',
            'sweetalert',
            'toastr',
        ]);
    }

    public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): ?Type
    {
        var_dump('ok');

        if (\count($functionCall->getArgs())) {
            return new ObjectType(Envelope::class);
        }

        return match ($functionReflection->getName()) {
            'flash' => TypeCombinator::union(new ObjectType(FlasherInterface::class), new ObjectType(NotificationFactoryInterface::class)),
            'noty' => new ObjectType(NotyInterface::class),
            'notyf' => new ObjectType(NotyfInterface::class),
            'sweetalert' => new ObjectType(SweetAlertInterface::class),
            'toastr' => new ObjectType(ToastrInterface::class),
            default => null,
        };
    }
}
