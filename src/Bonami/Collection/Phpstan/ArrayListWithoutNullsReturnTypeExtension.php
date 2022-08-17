<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\ArrayList;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

class ArrayListWithoutNullsReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return ArrayList::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'withoutNulls';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $type = $scope->getType($methodCall->var);

        $declaringClassReflection = $methodReflection->getDeclaringClass();
        $referencedClasses = $type->getReferencedClasses();

        if (in_array(ArrayList::class, $referencedClasses, true)) {
            return new GenericObjectType(
                $declaringClassReflection->getName(),
                [TypeCombinator::removeNull($type->getIterableValueType())]
            );
        }

        return $type;
    }
}
