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
    private const MAPPING = [
        'flash' => [FlasherInterface::class, NotificationFactoryInterface::class],
        'noty' => NotyInterface::class,
        'notyf' => NotyfInterface::class,
        'sweetalert' => SweetAlertInterface::class,
        'toastr' => ToastrInterface::class,
    ];

    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return \array_key_exists($functionReflection->getName(), self::MAPPING);
    }

    public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): ?Type
    {
        if (\count($functionCall->getArgs())) {
            return new ObjectType(Envelope::class);
        }

        $types = self::MAPPING[$functionReflection->getName()];

        if (\is_array($types)) {
            return TypeCombinator::union(...array_map(fn ($type) => new ObjectType($type), $types));
        }

        return new ObjectType($types);
    }
}
